<?php

namespace app\controllers\api\v2;

use yii\web\Controller;
use yii\web\Response;
use app\models\Price;
use app\models\Month;
use app\models\Tonnage;
use app\models\Type;
use Yii;

class PricesController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors(): array
    {
        return [
            'class' => \app\components\filters\TokenAuthMiddleware::class,
            'verbFilter' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'index' => ['GET'],
                    'create' => ['POST'],
                    'change' => ['PATCH'],
                    'delete' => ['DELETE'],
                    'options' => ['OPTIONS'],
                ],
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
        ];
    }

    // GET: Retrieve the list of tonnages from the database
    public function actionIndex(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Параметры для получения текущей цены из очереди (например, GET-запрос)
        $typeValue = Yii::$app->request->getQueryParam('type');
        $monthValue = Yii::$app->request->get('month');
        $tonnageValue = Yii::$app->request->get('tonnage');

        $rawType = Type::find()
        ->where(['name' => $typeValue]) // Предполагаем, что в таблице есть поле `name`
        ->one();

        $month = Month::find()
            ->where(['name' => $monthValue]) // Предполагаем, что в таблице есть поле `name`
            ->one();

        $tonnage = Tonnage::find()
            ->where(['value' => $tonnageValue]) // Предполагаем, что в таблице есть поле `value`
            ->one();
        // Ищем текущую цену по переданным параметрам
        $currentPrice = null;
        if ($rawType && $month && $tonnage) {
            $priceRecord = Price::find()
                ->where([
                    'raw_type_id' => $rawType,
                    'month_id' => $month,
                    'tonnage_id' => $tonnage,
                ])
                ->one();
            //return [$priceRecord];
            if ($priceRecord) {
                $currentPrice = $priceRecord->price;
            }
            if (!$priceRecord) {
                Yii::$app->response->statusCode = 404;
                return [
                    'message' => "Стоимость для выбранных параметров отсутствует",
                ];
            }
        }

        // Получаем все цены для формирования полного списка
        $prices = Price::find()
            ->with(['rawType', 'month', 'tonnage'])
            ->all();

        $priceList = [];

        foreach ($prices as $price) {
            $rawTypeName = $price->rawType->name;       // Название типа сырья
            $monthName = $price->month->name;          // Название месяца
            $tonnageValue = $price->tonnage->value;    // Значение тоннажа

            // Структурируем данные
            $priceList[$rawTypeName][$monthName][$tonnageValue] = $price->price;
        }
        Yii::$app->response->statusCode = 200;
        // Возвращаем результат
        return [
            'price' => $currentPrice, // Нынешняя цена по параметрам
            'price_list' => $priceList,
        ];
    }

    public function actionCreate(): array|null
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;
        $data = json_decode($request->getRawBody(), true);
        $monthValue = $data['month'] ?? null;
        $tonnageValue = $data['tonnage'] ?? null;
        $typeValue = $data['type'] ?? null;
        $priceValue = $data['price'] ?? null;

        $rawType = Type::find()
        ->where(['name' => $typeValue]) // Предполагаем, что в таблице есть поле `name`
        ->one();

        $month = Month::find()
            ->where(['name' => $monthValue]) // Предполагаем, что в таблице есть поле `name`
            ->one();

        $tonnage = Tonnage::find()
            ->where(['value' => $tonnageValue]) // Предполагаем, что в таблице есть поле `value`
            ->one();
        
        if ($rawType && $month && $tonnage) {
            $priceRecord = Price::find()
                ->where([
                    'raw_type_id' => $rawType,
                    'month_id' => $month,
                    'tonnage_id' => $tonnage,
                ])
                ->one();

            if ($priceRecord) {
                Yii::$app->response->statusCode = 404;
                return null;
            }
        }

        if (!$rawType || !$month || !$tonnage) {
            Yii::$app->response->statusCode = 404;
            return null;
        }

        $price = new Price();
        $price->raw_type_id = $rawType->id;
        $price->tonnage_id = $tonnage->id;
        $price->month_id = $month->id;
        $price->price = $priceValue;

        if ($price->save()) {
            Yii::$app->response->statusCode = 201; // Успешное создание
            return null;
        }

        Yii::$app->response->statusCode = 500;
    }

    public function actionChange() : array|null
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Параметры для получения текущей цены из очереди (например, GET-запрос)
        $typeValue = Yii::$app->request->getQueryParam('type');
        $monthValue = Yii::$app->request->get('month');
        $tonnageValue = Yii::$app->request->get('tonnage');

        $request = Yii::$app->request;
        $data = json_decode($request->getRawBody(), true);
        $newPriceValue = $data['price'] ?? null;

        $rawType = Type::find()
        ->where(['name' => $typeValue]) // Предполагаем, что в таблице есть поле `name`
        ->one();

        $month = Month::find()
            ->where(['name' => $monthValue]) // Предполагаем, что в таблице есть поле `name`
            ->one();

        $tonnage = Tonnage::find()
            ->where(['value' => $tonnageValue]) // Предполагаем, что в таблице есть поле `value`
            ->one();
        
        //return [$rawType, $month, $tonnage, $newPriceValue];
        if (!$rawType || !$month || !$tonnage) {
            Yii::$app->response->statusCode = 404;
            return [
                'message' => 'Стоимость для выбранных параметров отсутствует',
            ];            
        }

        if ($rawType && $month && $tonnage) {
            $priceRecord = Price::find()
                ->where([
                    'raw_type_id' => $rawType,
                    'month_id' => $month,
                    'tonnage_id' => $tonnage,
                ])
                ->one();

            if ($priceRecord) {
                $priceRecord->price = $newPriceValue;

                if ($priceRecord->save()) {
                    Yii::$app->response->statusCode = 200;
                    return null;                    
                }
            }

            if (!$priceRecord) {
                Yii::$app->response->statusCode = 404;
                return [
                    'message' => 'Стоимость для выбранных параметров отсутствует',
                ];
            }
        }
    }

    public function actionDelete() : array|null
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Параметры для получения текущей цены из очереди (например, GET-запрос)
        $typeValue = Yii::$app->request->getQueryParam('type');
        $monthValue = Yii::$app->request->get('month');
        $tonnageValue = Yii::$app->request->get('tonnage');

        $rawType = Type::find()
        ->where(['name' => $typeValue]) // Предполагаем, что в таблице есть поле `name`
        ->one();

        $month = Month::find()
            ->where(['name' => $monthValue]) // Предполагаем, что в таблице есть поле `name`
            ->one();

        $tonnage = Tonnage::find()
            ->where(['value' => $tonnageValue]) // Предполагаем, что в таблице есть поле `value`
            ->one();
        
        //return [$rawType, $month, $tonnage, $newPriceValue];
        if (!$rawType || !$month || !$tonnage) {
            Yii::$app->response->statusCode = 404;
            return [
                'message' => 'Стоимость для выбранных параметров отсутствует',
            ];            
        }

        if ($rawType && $month && $tonnage) {
            $priceRecord = Price::find()
                ->where([
                    'raw_type_id' => $rawType,
                    'month_id' => $month,
                    'tonnage_id' => $tonnage,
                ])
                ->one();

            if ($priceRecord) {

                if ($priceRecord->delete()) {
                    Yii::$app->response->statusCode = 204;
                    return null;                    
                }
            }

            if (!$priceRecord) {
                Yii::$app->response->statusCode = 404;
                return [
                    'message' => 'Стоимость для выбранных параметров отсутствует',
                ];
            }
        }
    }

    public function actionOptions() 
    {
        Yii::$app->response->statusCode = 204;
    }
}
?>