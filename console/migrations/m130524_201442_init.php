<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(240)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->insert('user', [
            'username' => 'admin',
            'auth_key' => '\'1\', \'admin\', \'L5L3-VSrq6sB5IbOAiFbvCQP2LCej0v4\', \'$2y$13$AY7D7SjteyjjCFcvk3ErzeDEbIQHjS14y6KySdiGg.8nXDO/Obq.u\', NULL, \'frederol123@gmail.com\', \'10\', \'1539874920\', \'1539874920\'
',
            'password_hash' => '$2y$13$AY7D7SjteyjjCFcvk3ErzeDEbIQHjS14y6KySdiGg.8nXDO/Obq.u',
            'email' => 'frederol123@gmail.com',
            'status' => 10,
            'created_at' => 1539874920,
            'updated_at' => 1539874920

        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
