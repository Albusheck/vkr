<?php

use yii\db\Migration;

/**
 * Class m250415_135145_fill_archive_prices_table
 */
class m250415_135145_fill_archive_prices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $months = (new \yii\db\Query())->select(['id', 'year_id'])->from('months')->all();
        $rawTypes = (new \yii\db\Query())->select('id')->from('raw_types')->all();
        $tonnages = (new \yii\db\Query())->select('id')->from('tonnage')->all();

        foreach ($months as $month) {
            foreach ($rawTypes as $raw) {
                foreach ($tonnages as $tonnage) {
                    $this->insert('archive_prices', [
                        'price' => rand(10000, 25000),
                        'raw_type_id' => $raw['id'],
                        'tonnage_id' => $tonnage['id'],
                        'month_id' => $month['id'],
                        'year_id' => $month['year_id'],
                    ]);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('archive_prices');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250415_135145_fill_archive_prices_table cannot be reverted.\n";

        return false;
    }
    */
}
