<?php

use yii\db\Migration;

/**
 * Handles the creation of table `products_sections`.
 * Has foreign keys to the tables:
 *
 * - `products`
 * - `sections`
 */
class m181024_144307_create_junction_table_for_products_and_sections_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('products_sections', [
            'products_id' => $this->integer(),
            'sections_id' => $this->integer(),
            'PRIMARY KEY(products_id, sections_id)',
        ]);

        // creates index for column `products_id`
        $this->createIndex(
            'idx-products_sections-products_id',
            'products_sections',
            'products_id'
        );

        // add foreign key for table `products`
        $this->addForeignKey(
            'fk-products_sections-products_id',
            'products_sections',
            'products_id',
            'products',
            'id',
            'CASCADE'
        );

        // creates index for column `sections_id`
        $this->createIndex(
            'idx-products_sections-sections_id',
            'products_sections',
            'sections_id'
        );

        // add foreign key for table `sections`
        $this->addForeignKey(
            'fk-products_sections-sections_id',
            'products_sections',
            'sections_id',
            'sections',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `products`
        $this->dropForeignKey(
            'fk-products_sections-products_id',
            'products_sections'
        );

        // drops index for column `products_id`
        $this->dropIndex(
            'idx-products_sections-products_id',
            'products_sections'
        );

        // drops foreign key for table `sections`
        $this->dropForeignKey(
            'fk-products_sections-sections_id',
            'products_sections'
        );

        // drops index for column `sections_id`
        $this->dropIndex(
            'idx-products_sections-sections_id',
            'products_sections'
        );

        $this->dropTable('products_sections');
    }
}
