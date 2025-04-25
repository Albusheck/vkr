<?php

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        $user = User::findByEmail($this->email);

        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError($attribute, 'Неверный email или пароль.');
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login(User::findByEmail($this->email));
        }
        return false;
    }
}
