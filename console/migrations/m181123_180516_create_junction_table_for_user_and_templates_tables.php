<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_templates`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `templates`
 */
class m181123_180516_create_junction_table_for_user_and_templates_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_templates', [
            'user_id' => $this->integer(),
            'templates_id' => $this->integer(),
            'PRIMARY KEY(user_id, templates_id)',
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-user_templates-user_id',
            'user_templates',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-user_templates-user_id',
            'user_templates',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `templates_id`
        $this->createIndex(
            'idx-user_templates-templates_id',
            'user_templates',
            'templates_id'
        );

        // add foreign key for table `templates`
        $this->addForeignKey(
            'fk-user_templates-templates_id',
            'user_templates',
            'templates_id',
            'templates',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-user_templates-user_id',
            'user_templates'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-user_templates-user_id',
            'user_templates'
        );

        // drops foreign key for table `templates`
        $this->dropForeignKey(
            'fk-user_templates-templates_id',
            'user_templates'
        );

        // drops index for column `templates_id`
        $this->dropIndex(
            'idx-user_templates-templates_id',
            'user_templates'
        );

        $this->dropTable('user_templates');
    }
}
