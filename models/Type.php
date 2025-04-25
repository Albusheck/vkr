<?php
namespace app\models;

use yii\db\ActiveRecord;

class Type extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'raw_types'; // Имя таблицы в базе данных
    }

    public function rules(): array
    {
        return [
            [['type'], 'required'],
            [['type'], 'string'],
        ];
    }
}
?>