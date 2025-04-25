<?php

use yii\db\Migration;

/**
 * Class m250415_133313_fill_raw_types_table
 */
class m250415_133313_fill_raw_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('raw_types', ['type'], [
            ['Пшеница'],
            ['Ячмень'],
            ['Кукуруза'],
            ['Овёс'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('raw_types');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250415_133313_fill_raw_types_table cannot be reverted.\n";

        return false;
    }
    */
}
