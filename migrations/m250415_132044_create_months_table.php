<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%months}}`.
 */
class m250415_132044_create_months_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%months}}', [
            'id' => $this->primaryKey()->unsigned(),
            'month' => $this->integer(),
            'year_id' => $this->integer()->unsigned(),
        ]);

        $this->addForeignKey(
            'fk_months_year_id',
            '{{%months}}',
            'year_id',
            '{{%years}}',
            'id',
            'CASCADE'
        );
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_months_year_id', '{{%months}}');
        $this->dropTable('{{%months}}');
    }
}
