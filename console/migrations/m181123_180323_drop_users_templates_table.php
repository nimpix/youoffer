<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `users_templates`.
 */
class m181123_180323_drop_users_templates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('users_templates');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('users_templates', [
            'id' => $this->primaryKey(),
        ]);
    }
}
