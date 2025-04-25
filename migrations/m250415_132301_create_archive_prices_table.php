<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%archive_prices}}`.
 */
class m250415_132301_create_archive_prices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%archive_prices}}', [
            'id' => $this->primaryKey()->unsigned(),
            'price' => $this->decimal(10, 2),
            'raw_type_id' => $this->integer()->unsigned(),
            'tonnage_id' => $this->integer()->unsigned(),
            'month_id' => $this->integer()->unsigned(),
            'year_id' => $this->integer()->unsigned(),
        ]);

        $this->addForeignKey('fk_ap_raw_type', '{{%archive_prices}}', 'raw_type_id', '{{%raw_types}}', 'id');
        $this->addForeignKey('fk_ap_tonnage', '{{%archive_prices}}', 'tonnage_id', '{{%tonnage}}', 'id');
        $this->addForeignKey('fk_ap_month', '{{%archive_prices}}', 'month_id', '{{%months}}', 'id');
        $this->addForeignKey('fk_ap_year', '{{%archive_prices}}', 'year_id', '{{%years}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_ap_raw_type', '{{%archive_prices}}');
        $this->dropForeignKey('fk_ap_tonnage', '{{%archive_prices}}');
        $this->dropForeignKey('fk_ap_month', '{{%archive_prices}}');
        $this->dropForeignKey('fk_ap_year', '{{%archive_prices}}');
        $this->dropTable('{{%archive_prices}}');
    }
}
