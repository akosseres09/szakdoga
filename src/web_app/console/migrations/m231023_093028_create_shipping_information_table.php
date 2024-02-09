<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shipping_information}}`.
 */
class m231023_093028_create_shipping_information_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%shipping_information}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'country' => $this->string(128)->notNull(),
            'state' => $this->string(64)->notNull(),
            'postcode' => $this->integer()->notNull(),
            'city' => $this->string(64)->notNull(),
            'street' => $this->string(64)->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-shipping_information-user_id}}',
            '{{%shipping_information}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-shipping_information-user_id}}',
            '{{%shipping_information}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%User}}`
        $this->dropForeignKey(
            '{{%fk-shipping_information-user_id}}',
            '{{%shipping_information}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-shipping_information-user_id}}',
            '{{%shipping_information}}'
        );

        $this->dropTable('{{%shipping_information}}');
    }
}
