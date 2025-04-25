<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class CalculationHistory extends ActiveRecord
{
    public static function tableName()
    {
        return 'calculation_history';
    }

    public function rules()
    {
        return [
            [['user_id', 'raw_type', 'tonnage', 'month', 'price'], 'required'],
            [['user_id', 'tonnage'], 'integer'],
            [['price'], 'number'],
            [['created_at'], 'safe'],
            [['raw_type', 'month'], 'string', 'max' => 255],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
