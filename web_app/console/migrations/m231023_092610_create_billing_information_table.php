<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%billing_information}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%User}}`
 */
class m231023_092610_create_billing_information_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%billing_information}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'country' => $this->string(128)->notNull(),
            'state' => $this->string(64)->notNull(),
            'postcode' => $this->integer()->notNull(),
            'city' => $this->string(64)->notNull(),
            'street' => $this->string(128)->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-billing_information-user_id}}',
            '{{%billing_information}}',
            'user_id'
        );

        // add foreign key for table `{{%User}}`
        $this->addForeignKey(
            '{{%fk-billing_information-user_id}}',
            '{{%billing_information}}',
            'user_id',
            '{{%User}}',
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
            '{{%fk-billing_information-user_id}}',
            '{{%billing_information}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-billing_information-user_id}}',
            '{{%billing_information}}'
        );

        $this->dropTable('{{%billing_information}}');
    }
}
