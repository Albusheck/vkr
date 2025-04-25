<?php

namespace app\controllers\api\v2;

use yii\web\Controller;
use yii\web\Response;
use app\models\Tonnage;
use Yii;

class TonnagesController extends Controller
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

    // GET: Retrieve the list of tonnages from the database
    public function actionIndex(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $tonnages = \yii\helpers\ArrayHelper::getColumn(Tonnage::find()->all(), 'value');
        return $tonnages;
    }

    // POST: Create a new tonnage entry in the database
    public function actionCreate(): array|null
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;
        $data = json_decode($request->getRawBody(), true);
        $tonnageValue = $data['tonnage'] ?? null;

        // Check if the tonnage already exists
        $existingTonnage = Tonnage::findOne(['value' => $tonnageValue]);
        if ($existingTonnage) {
            Yii::$app->response->statusCode = 400;
            return [
                'message' => 'Тоннаж уже существует',
            ];
        }

        // Create a new tonnage
        $tonnage = new Tonnage();
        $tonnage->value = $tonnageValue;

        if ($tonnage->save()) {
            Yii::$app->response->statusCode = 201;
            return null;
        }
    }

    public function actionDelete(): array|null
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $tonnageValue = Yii::$app->request->getQueryParam('id');

        $tonnage = Tonnage::findOne(['value' => $tonnageValue]);

        if (!$tonnage) {
            Yii::$app->response->statusCode = 404;
            return [
                'message' => 'Тоннаж не найден.',
            ];
        }

        if ($tonnage->delete()) {
            Yii::$app->response->statusCode = 204;
            return null;
        }
    }

    public function actionOptions() 
    {
        Yii::$app->response->statusCode = 204;
    }
}
?>