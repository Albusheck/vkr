<?php

namespace app\models;

use yii\db\ActiveRecord;

class Year extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'years'; // Имя таблицы в базе данных
    }

    public function rules(): array
    {
        return [
            [['year'], 'required'],
            [['year'], 'integer'],
        ];
    }

    public function getArchivePrices()
    {
        return $this->hasMany(ArchivePrice::class, ['year_id' => 'id']);
    }

}
?>
