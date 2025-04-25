<?php

namespace app\models;

use yii\base\Model;

class CalculationForm extends Model
{
    public $month;

    public $tonnage;

    public $type;
    public $year;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }
    public function attributeLabels(): array
    {
        return [
            'month' => 'Месяц',
            'year' => 'Год',
            'tonnage' => 'Тоннаж',
            'type' => 'Тип сырья'
        ];
    }

    public function rules(): array
    {
        return [
            [
                [
                    'month',
                    'tonnage',
                    'type',
                    'year',
                ],
                'required',
                'message' => 'Необходимо выбрать значение поля {attribute}',
            ],
        ];
    }
}