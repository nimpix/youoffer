<?php

use yii\db\Migration;

/**
 * Class m181003_173318_catalog
 */
class m181003_173318_catalog extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('sections', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'left_key' => $this->integer(10)->notNull()->defaultValue(0),
            'right_key' => $this->integer(10)->notNull()->defaultValue(0),
            'level' => $this->integer(10)->notNull()->defaultValue(0),
            'url' => $this->string()->notNull()->defaultValue(''),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181003_173318_catalog cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181003_173318_catalog cannot be reverted.\n";

        return false;
    }
    */
}
