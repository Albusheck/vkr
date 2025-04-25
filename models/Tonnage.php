<?php

namespace app\models;

use yii\db\ActiveRecord;

class Tonnage extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'tonnage'; // Имя таблицы в базе данных
    }

    public function rules(): array
    {
        return [
            [['tonnage'], 'required'],
            [['tonnage'], 'integer'],
        ];
    }
}
?>
