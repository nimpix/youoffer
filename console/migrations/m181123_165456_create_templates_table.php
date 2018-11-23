<?php

use yii\db\Migration;

/**
 * Handles the creation of table `templates`.
 */
class m181123_165456_create_templates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('templates', [
            'id' => $this->primaryKey(),
            'name' => $this->integer()->defaultValue(0),
            'data' => $this->string(2000)->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('templates');
    }
}
