<?php

use yii\db\Migration;

/**
 * Class m250415_132709_fill_months_table
 */
class m250415_132709_fill_months_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $monthNames = [
            1 => 'Январь',
            2 => 'Февраль',
            3 => 'Март',
            4 => 'Апрель',
            5 => 'Май',
            6 => 'Июнь',
            7 => 'Июль',
            8 => 'Август',
            9 => 'Сентябрь',
            10 => 'Октябрь',
            11 => 'Ноябрь',
            12 => 'Декабрь',
        ];

        for ($yearId = 1; $yearId <= 4; $yearId++) {
            foreach ($monthNames as $month => $name) {
                $this->insert('months', [
                    'month' => $month,
                    'name' => $name,
                    'year_id' => $yearId,
                ]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('months');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250415_132709_fill_months_table cannot be reverted.\n";

        return false;
    }
    */
}
