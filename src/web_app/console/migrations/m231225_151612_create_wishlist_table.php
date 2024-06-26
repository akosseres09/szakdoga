<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%wishlist}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%product}}`
 */
class m231225_151612_create_wishlist_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%wishlist}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'added_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull()
        ]);

        $this->createIndex(
            '{{%idx-unique-user-id-product-id}}',
            '{{%wishlist}}',
            ['user_id', 'product_id'],
            true
        );
        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-wishlist-user_id}}',
            '{{%wishlist}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-wishlist-user_id}}',
            '{{%wishlist}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-wishlist-product_id}}',
            '{{%wishlist}}',
            'product_id'
        );

        // add foreign key for table `{{%product}}`
        $this->addForeignKey(
            '{{%fk-wishlist-product_id}}',
            '{{%wishlist}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-wishlist-user_id}}',
            '{{%wishlist}}'
        );
        $this->dropIndex(
            '{{%idx-unique-user-id-product-id}}',
            '{{%wishlist}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-wishlist-user_id}}',
            '{{%wishlist}}'
        );

        // drops foreign key for table `{{%product}}`
        $this->dropForeignKey(
            '{{%fk-wishlist-product_id}}',
            '{{%wishlist}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-wishlist-product_id}}',
            '{{%wishlist}}'
        );

        $this->dropTable('{{%wishlist}}');
    }
}
