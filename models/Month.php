<?php

namespace app\models;

use yii\db\ActiveRecord;

class Month extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'months'; // Имя таблицы в базе данных
    }

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
        ];
    }
}
?>
