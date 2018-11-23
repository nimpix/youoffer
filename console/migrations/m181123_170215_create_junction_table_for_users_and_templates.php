<?php

use yii\db\Migration;

/**
 * Class m181123_170215_create_junction_table_for_users_and_templates
 */
class m181123_170215_create_junction_table_for_users_and_templates extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181123_170215_create_junction_table_for_users_and_templates cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181123_170215_create_junction_table_for_users_and_templates cannot be reverted.\n";

        return false;
    }
    */
}
