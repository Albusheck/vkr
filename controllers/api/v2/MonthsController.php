<?php

namespace app\controllers\api\v2;

use yii\web\Controller;
use yii\web\Response;
use app\models\Month;
use Yii;

class MonthsController extends Controller
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
                    'delete' => ['DELETE'],
                    'options' => ['OPTIONS'],
                ],
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
        ];
    }

    // GET: Retrieve the list of months from the database
    public function actionIndex(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $months = \yii\helpers\ArrayHelper::getColumn(Month::find()->all(), 'name');
        return $months;
    }

    // POST: Create a new month entry in the database
    public function actionCreate(): array|null
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
    
        $request = Yii::$app->request;
        $data = json_decode($request->getRawBody(), true); // Получаем JSON из "raw body"
        $monthName = $data['month'] ?? null;
    
        // Проверяем, существует ли месяц с таким именем
        $existingMonth = Month::findOne(['name' => $monthName]);
        if ($existingMonth) {
            Yii::$app->response->statusCode = 400; // Конфликт данных
            return [
                'message' => 'Месяц уже существует',
            ];
        }
    
        // Создаём новый месяц
        $month = new Month();
        $month->name = $monthName;
    
        if ($month->save()) {
            Yii::$app->response->statusCode = 201; // Успешное создание
            return null;
        }

    }
    

    public function actionDelete(): array|null
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
    
        // Получаем имя месяца из параметров запроса
        $monthName = Yii::$app->request->getQueryParam('name');
    
        // Ищем месяц в базе данных по имени
        $month = Month::findOne(['name' => $monthName]);
    
        // Если месяц не найден
        if (!$month) {
            Yii::$app->response->statusCode = 404; // Месяц не найден
            return [
                'message' => 'Месяц не найден.',
            ];
        }
    
        // Удаляем месяц
        if ($month->delete()) {
            Yii::$app->response->statusCode = 204; // Успешное удаление
            return null; // Пустой ответ
        }
    }
    
    public function actionOptions() 
    {
        Yii::$app->response->statusCode = 204;
    }
}

?>
