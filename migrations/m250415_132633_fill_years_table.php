<?php

use yii\db\Migration;

/**
 * Class m250415_132633_fill_years_table
 */
class m250415_132633_fill_years_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('years', ['year'], [
            [2022],
            [2023],
            [2024],
            [2025],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('years');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250415_132633_fill_years_table cannot be reverted.\n";

        return false;
    }
    */
}
