<?php

namespace app\controllers\api\v2;

use yii\web\Controller;
use yii\web\Response;
use app\models\Type;
use Yii;

class TypesController extends Controller
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

        $types = \yii\helpers\ArrayHelper::getColumn(Type::find()->all(), 'name');
        return $types;
    }

    // POST: Create a new tonnage entry in the database
    public function actionCreate(): array|null
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;
        $data = json_decode($request->getRawBody(), true);
        $typeValue = $data['type'] ?? null;

        // Check if the tonnage already exists
        $existingTonnage = Type::findOne(['name' => $typeValue]);
        if ($existingTonnage) {
            Yii::$app->response->statusCode = 400;
            return [
                'message' => 'Тип сырья уже существует',
            ];
        }

        // Create a new tonnage
        $type = new Type();
        $type->name = $typeValue;

        if ($type->save()) {
            Yii::$app->response->statusCode = 201;
            return null;
        }
    }

    public function actionDelete(): array|null
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $typeValue = Yii::$app->request->getQueryParam('id');

        $type = Type::findOne(['name' => $typeValue]);

        if (!$type) {
            Yii::$app->response->statusCode = 404;
            return [
                'message' => 'Тоннаж не найден.',
            ];
        }

        if ($type->delete()) {
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