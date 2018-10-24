<?php

use yii\db\Migration;

/**
 * Handles the creation of table `brands_merchant`.
 * Has foreign keys to the tables:
 *
 * - `brands`
 * - `merchant`
 */
class m181024_105131_create_junction_table_for_brands_and_merchant_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('brands_merchant', [
            'brands_id' => $this->integer(),
            'merchant_id' => $this->integer(),
            'PRIMARY KEY(brands_id, merchant_id)',
        ]);

        // creates index for column `brands_id`
        $this->createIndex(
            'idx-brands_merchant-brands_id',
            'brands_merchant',
            'brands_id'
        );

        // add foreign key for table `brands`
        $this->addForeignKey(
            'fk-brands_merchant-brands_id',
            'brands_merchant',
            'brands_id',
            'brands',
            'id',
            'CASCADE'
        );

        // creates index for column `merchant_id`
        $this->createIndex(
            'idx-brands_merchant-merchant_id',
            'brands_merchant',
            'merchant_id'
        );

        // add foreign key for table `merchant`
        $this->addForeignKey(
            'fk-brands_merchant-merchant_id',
            'brands_merchant',
            'merchant_id',
            'merchant',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `brands`
        $this->dropForeignKey(
            'fk-brands_merchant-brands_id',
            'brands_merchant'
        );

        // drops index for column `brands_id`
        $this->dropIndex(
            'idx-brands_merchant-brands_id',
            'brands_merchant'
        );

        // drops foreign key for table `merchant`
        $this->dropForeignKey(
            'fk-brands_merchant-merchant_id',
            'brands_merchant'
        );

        // drops index for column `merchant_id`
        $this->dropIndex(
            'idx-brands_merchant-merchant_id',
            'brands_merchant'
        );

        $this->dropTable('brands_merchant');
    }
}
