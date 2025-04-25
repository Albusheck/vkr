<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%years}}`.
 */
class m250415_132001_create_years_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%years}}', [
            'id' => $this->primaryKey()->unsigned(),
            'year' => $this->integer(),
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%years}}');
    }
}
