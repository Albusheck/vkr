<?php

use yii\db\Migration;

/**
 * Class m250415_133202_add_name_to_months_table
 */
class m250415_133202_add_name_to_months_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('months', 'name', $this->string(20)->after('month'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('months', 'name');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250415_133202_add_name_to_months_table cannot be reverted.\n";

        return false;
    }
    */
}
