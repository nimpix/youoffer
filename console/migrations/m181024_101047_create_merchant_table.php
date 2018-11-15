<?php

use yii\db\Migration;

/**
 * Handles the creation of table `merchant`.
 */
class m181024_101047_create_merchant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('merchant', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'image' => $this->string(),
            'description' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('merchant');
    }
}
