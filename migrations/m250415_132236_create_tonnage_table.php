<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tonnage}}`.
 */
class m250415_132236_create_tonnage_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tonnage}}', [
            'id' => $this->primaryKey()->unsigned(),
            'tonnage' => $this->decimal(10, 2),
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tonnage}}');
    }
}
