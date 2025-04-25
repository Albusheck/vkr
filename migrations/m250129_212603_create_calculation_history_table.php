<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%calculation_history}}`.
 */
class m250129_212603_create_calculation_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('calculation_history', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'raw_type' => $this->string()->notNull(),
            'tonnage' => $this->integer()->notNull(),
            'month' => $this->string()->notNull(),
            'year' => $this->integer()->notNull(),
            'price' => $this->decimal(10,2)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%calculation_history}}');
    }
}
