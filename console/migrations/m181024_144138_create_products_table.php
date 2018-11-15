<?php

use yii\db\Migration;

/**
 * Handles the creation of table `products`.
 * Has foreign keys to the tables:
 *
 * - `brands`
 * - `merchant`
 */
class m181024_144138_create_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('products', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'category_id' => $this->integer(),
            'brand_id' => $this->integer()->defaultValue(0),
            'merchant_id' => $this->integer(),
            'description' => $this->string(),
            'articul' => $this->string(),
            'image' => $this->string(),
            'price_roznica' => $this->integer(),
            'price_opt' => $this->integer(),
            'status' => $this->string(),
            'waiting' => $this->string(),
            'weight' => $this->string(),
            'amount' => $this->integer(),
            'size' => $this->string(),
            'thumbnails' => $this->string(),
        ]);

        // creates index for column `brand_id`
        $this->createIndex(
            'idx-products-brand_id',
            'products',
            'brand_id'
        );

        // add foreign key for table `brands`
        $this->addForeignKey(
            'fk-products-brand_id',
            'products',
            'brand_id',
            'brands',
            'id',
            'CASCADE'
        );

        // creates index for column `merchant_id`
        $this->createIndex(
            'idx-products-merchant_id',
            'products',
            'merchant_id'
        );

        // add foreign key for table `merchant`
        $this->addForeignKey(
            'fk-products-merchant_id',
            'products',
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
            'fk-products-brand_id',
            'products'
        );

        // drops index for column `brand_id`
        $this->dropIndex(
            'idx-products-brand_id',
            'products'
        );

        // drops foreign key for table `merchant`
        $this->dropForeignKey(
            'fk-products-merchant_id',
            'products'
        );

        // drops index for column `merchant_id`
        $this->dropIndex(
            'idx-products-merchant_id',
            'products'
        );

        $this->dropTable('products');
    }
}
