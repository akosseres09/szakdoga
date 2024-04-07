<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m240407_141932_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(12)->notNull()
        ]);

        $this->createIndex(
        '{{%idx-order-created_at}}',
        '{{%order}}',
        'created_at'
        );

        $this->createIndex(
            '{{%idx-order-user_id}}',
            '{{%order}}',
            'user_id'
        );

        $this->createIndex(
            '{{%idx-order-product_id}}',
            '{{%order}}',
            'product_id'
        );

        $this->addForeignKey(
            '{{%fk-order-product_id}}',
            '{{%order}}',
            'product_id',
            '{{%product}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            '{{%fk-order-user_id}}',
            '{{%order}}',
            'user_id',
            '{{%user}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
        '{{%fk-order-product_id}}',
        '{{%order}}'
        );

        $this->dropForeignKey(
            '{{%fk-order-user_id}}',
            '{{%order}}'
        );

        $this->dropIndex(
        '{{%idx-order-product_id}}',
        '{{%order}}'
        );

        $this->dropIndex(
            '{{%idx-order-user_id}}',
            '{{%order}}'
        );

        $this->dropIndex(
        '{{%idx-order-created_at}}',
        '{{%order}}'
        );

        $this->dropTable('{{%order}}');
    }
}
