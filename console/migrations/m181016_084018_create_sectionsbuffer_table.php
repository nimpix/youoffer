<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sectionsbuffer`.
 */
class m181016_084018_create_sectionsbuffer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sectionsbuffer', [
            'id' => $this->primaryKey(),
            'tree' => $this->integer()->notNull(),
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('sectionsbuffer');
    }
}
