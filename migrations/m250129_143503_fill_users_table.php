<?php

use yii\db\Migration;

/**
 * Class m250129_143503_fill_users_table
 */
class m250129_143503_fill_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */    public function safeUp()
    {
        $this->execute("
            INSERT INTO users (name, email, password) VALUES
            ('Никита', 'urazov-nik@mail.ru', '" . Yii::$app->getSecurity()->generatePasswordHash('1234') . "'),
            ('Мария Петрова', 'maria@example.com', '" . Yii::$app->getSecurity()->generatePasswordHash('securepass456') . "'),
            ('Алексей Смирнов', 'alexey@example.com', '" . Yii::$app->getSecurity()->generatePasswordHash('mypassword789') . "');
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250129_143503_fill_users_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250129_143503_fill_users_table cannot be reverted.\n";

        return false;
    }
    */
}
