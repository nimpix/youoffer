<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sections_sectionsrel`.
 * Has foreign keys to the tables:
 *
 * - `sections`
 * - `sectionsrel`
 */
class m181005_174104_create_junction_table_for_sections_and_sectionsrel_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sections_sectionsrel', [
            'sections_id' => $this->integer(),
            'sectionsrel_id' => $this->integer(),
            'PRIMARY KEY(sections_id, sectionsrel_id)',
        ]);

        // creates index for column `sections_id`
        $this->createIndex(
            'idx-sections_sectionsrel-sections_id',
            'sections_sectionsrel',
            'sections_id'
        );

        // add foreign key for table `sections`
        $this->addForeignKey(
            'fk-sections_sectionsrel-sections_id',
            'sections_sectionsrel',
            'sections_id',
            'sections',
            'id',
            'CASCADE'
        );

        // creates index for column `sectionsrel_id`
        $this->createIndex(
            'idx-sections_sectionsrel-sectionsrel_id',
            'sections_sectionsrel',
            'sectionsrel_id'
        );

        // add foreign key for table `sectionsrel`
        $this->addForeignKey(
            'fk-sections_sectionsrel-sectionsrel_id',
            'sections_sectionsrel',
            'sectionsrel_id',
            'sectionsrel',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `sections`
        $this->dropForeignKey(
            'fk-sections_sectionsrel-sections_id',
            'sections_sectionsrel'
        );

        // drops index for column `sections_id`
        $this->dropIndex(
            'idx-sections_sectionsrel-sections_id',
            'sections_sectionsrel'
        );

        // drops foreign key for table `sectionsrel`
        $this->dropForeignKey(
            'fk-sections_sectionsrel-sectionsrel_id',
            'sections_sectionsrel'
        );

        // drops index for column `sectionsrel_id`
        $this->dropIndex(
            'idx-sections_sectionsrel-sectionsrel_id',
            'sections_sectionsrel'
        );

        $this->dropTable('sections_sectionsrel');
    }
}
