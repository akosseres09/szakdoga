<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cart}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%product}}`
 */
class m231223_123217_create_cart_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cart}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'price' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull(),
            'size' => $this->string(16)
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-cart-user_id}}',
            '{{%cart}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-cart-user_id}}',
            '{{%cart}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-cart-product_id}}',
            '{{%cart}}',
            'product_id'
        );

        // add foreign key for table `{{%product}}`
        $this->addForeignKey(
            '{{%fk-cart-product_id}}',
            '{{%cart}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-cart-user_id}}',
            '{{%cart}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-cart-user_id}}',
            '{{%cart}}'
        );

        // drops foreign key for table `{{%product}}`
        $this->dropForeignKey(
            '{{%fk-cart-product_id}}',
            '{{%cart}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-cart-product_id}}',
            '{{%cart}}'
        );

        $this->dropTable('{{%cart}}');
    }
}
