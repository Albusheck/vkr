<?php

namespace app\components\filters;

use yii\base\ActionFilter;
use yii\web\UnauthorizedHttpException;

class TokenAuthMiddleware extends ActionFilter
{
    public function beforeAction($action): true
    {
        $token = \Yii::$app->request->headers->get('X-Api-Key');

        if (\Yii::$app->request->method === 'OPTIONS') {
            return true;
        }

        if ($token !== getenv('X_API_KEY')) {
            throw new UnauthorizedHttpException('Авторизация не выполнена');
        }

        return true;
    }
}