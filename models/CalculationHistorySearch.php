<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class CalculationHistorySearch extends CalculationHistory
{
    public function rules()
    {
        return [
            [['raw_type', 'month', 'created_at'], 'safe'],
            [['tonnage'], 'integer'],
        ];
    }

    public function search($params)
    {
        $query = CalculationHistory::find();

        if (!\Yii::$app->user->can('administrator')) {
            $query->where(['user_id' => \Yii::$app->user->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['tonnage' => $this->tonnage])
              ->andFilterWhere(['like', 'raw_type', $this->raw_type])
              ->andFilterWhere(['like', 'month', $this->month])
              ->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}
