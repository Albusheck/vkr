<?php

use yii\db\Migration;

/**
 * Class m250415_133556_fill_tonnages_table
 */
class m250415_133556_fill_tonnages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('tonnage', ['tonnage'], [
            [25],
            [50],
            [75],
            [100],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('tonnages');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250415_133556_fill_tonnages_table cannot be reverted.\n";

        return false;
    }
    */
}
