<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sectionsrel`.
 */
class m181005_173933_create_sectionsrel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sectionsrel', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'url' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('sectionsrel');
    }
}
