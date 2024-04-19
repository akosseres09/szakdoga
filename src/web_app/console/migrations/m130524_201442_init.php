<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function safeUp(): void
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'is_admin' => $this->smallInteger()->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'deleted_at' => $this->integer()->null()->defaultValue(null),
            'verification_token' => $this->string()->defaultValue(null),
            'last_login_at' => $this->integer(),
            'stripe_cus' => $this->string(30)->defaultValue(null)
        ], $tableOptions);

        $this->createIndex('{{%idx-user-username}}', '{{%user}}', 'username');
        $this->createIndex('{{%idx-user-email}}', '{{%user}}', 'email');
        $this->createIndex('{{%idx-user-is_admin}}', '{{%user}}', 'is_admin');
        $this->createIndex('{{%idx-user-status}}', '{{%user}}', 'status');
        $this->createIndex('{{%idx-user-deleted_at}}', '{{%user}}', 'deleted_at');
        $this->createIndex('{{%idx-user-created_at}}', '{{%user}}', 'created_at');
    }

    public function safeDown(): void
    {
        $this->dropIndex('{{%idx-user-username}}','{{%user}}');
        $this->dropIndex('{{%idx-user-email}}','{{%user}}');
        $this->dropIndex('{{%idx-user-is_admin}}','{{%user}}');
        $this->dropIndex('{{%idx-user-status}}','{{%user}}');
        $this->dropIndex('{{%idx-user-deleted_at}}','{{%user}}');
        $this->dropIndex('{{%idx-user-created_at}}','{{%user}}');
        $this->dropTable('{{%user}}');
    }
}
