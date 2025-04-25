<?php

namespace app\controllers\api\v1;
use app\models\CalculationRepository;
class PricesController extends \yii\web\Controller
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
                ],
            ],
        ];
    }

    public function actionIndex(): array
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // Получение значений
    $month = mb_strtolower($_GET['month']);
    $tonnage = $_GET['tonnage'];
    $type = mb_strtolower($_GET['type']);

    // Проверка параметров
    $repository = new CalculationRepository(
        \Yii::$app->params['lists'],
        \Yii::$app->params['prices'],
    );

    if ($repository->isPriceExists($month, (int) $tonnage, $type) === true) {

        $response = [
            'price' => $repository->getPrice($month,$tonnage,$type),
            'price_list' => [$type => $repository->getPriceListByRawType($type)],
        ];        

    }

    if ($repository->isPriceExists($month, (int) $tonnage, $type) === false) {

        \Yii::$app->response->statusCode = '400';

        $response = [
            'message' => "Стоимость для выбранных параметров отсутствует",
        ];
    }

    return $response;
    }
}