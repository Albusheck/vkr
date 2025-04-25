<?php

namespace app\models;

use yii\base\Model;

class RegisterForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $confirm_password;

    // Конструктор, если необходимо
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    // Модификатор для меток полей
    public function attributeLabels(): array
    {
        return [
            'name' => 'Имя',
            'email' => 'Электронная почта',
            'password' => 'Пароль',
            'confirm_password' => 'Подтверждение пароля',
        ];
    }

    // Правила валидации
    public function rules(): array
    {
        return [
            [['name', 'email', 'password', 'confirm_password'], 'required', 'message' => 'Необходимо заполнить поле {attribute}.'],
            ['email', 'email', 'message' => 'Некорректный адрес электронной почты.'],
            ['password', 'match', 'pattern' => '/^(?=.*\d)(?=.*[A-Za-z]).{6,}$/', 'message' => 'Пароль должен содержать хотя бы одну цифру и одну букву.'],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],
        ];
    }

}
