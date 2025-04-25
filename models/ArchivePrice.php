<?php

namespace app\models;

use yii\db\ActiveRecord;

class ArchivePrice extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'archive_prices'; // Имя таблицы в базе данных
    }

    public function rules(): array
    {
        return [
            [['price', 'tonnage_id', 'month_id', 'raw_type_id', 'year_id'], 'required'],
            [['price', 'tonnage_id', 'month_id', 'raw_type_id', 'year_id'], 'integer'],
        ];
    }

    public function getRawType()
    {
        return $this->hasOne(Type::class, ['id' => 'raw_type_id']);
    }

    public function getMonth()
    {
        return $this->hasOne(Month::class, ['id' => 'month_id']);
    }

    public function getTonnage()
    {
        return $this->hasOne(Tonnage::class, ['id' => 'tonnage_id']);
    }

    public function getYear()
    {
        return $this->hasOne(Year::class, ['id' => 'year_id']);
    }
}
?>
