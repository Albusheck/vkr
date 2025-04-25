<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%forecast_prices}}`.
 */
class m250415_132341_create_forecast_prices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%forecast_prices}}', [
            'id' => $this->primaryKey()->unsigned(),
            'predicted_price' => $this->decimal(10, 2),
            'raw_type_id' => $this->integer()->unsigned(),
            'tonnage_id' => $this->integer()->unsigned(),
            'month_id' => $this->integer()->unsigned(),
            'year_id' => $this->integer()->unsigned(),
        ]);

        $this->addForeignKey('fk_fp_raw_type', '{{%forecast_prices}}', 'raw_type_id', '{{%raw_types}}', 'id');
        $this->addForeignKey('fk_fp_tonnage', '{{%forecast_prices}}', 'tonnage_id', '{{%tonnage}}', 'id');
        $this->addForeignKey('fk_fp_month', '{{%forecast_prices}}', 'month_id', '{{%months}}', 'id');
        $this->addForeignKey('fk_fp_year', '{{%forecast_prices}}', 'year_id', '{{%years}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_fp_raw_type', '{{%forecast_prices}}');
        $this->dropForeignKey('fk_fp_tonnage', '{{%forecast_prices}}');
        $this->dropForeignKey('fk_fp_month', '{{%forecast_prices}}');
        $this->dropForeignKey('fk_fp_year', '{{%forecast_prices}}');
        $this->dropTable('{{%forecast_prices}}');
    }
}
