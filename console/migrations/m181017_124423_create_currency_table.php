<?php

use yii\db\Migration;

/**
 * Handles the creation of table `currency`.
 */
class m181017_124423_create_currency_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('currency', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20),
            'kurs' => $this->integer(),
        ]);

        $this->insert('currency', [
            'name' => 'RUB',
            'kurs' => '0',
        ]);
        $this->insert('currency', [
            'name' => 'USD',
            'kurs' => '60',
        ]);
        $this->insert('currency', [
            'name' => 'EUR',
            'kurs' => '70',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('currency');
    }
}
