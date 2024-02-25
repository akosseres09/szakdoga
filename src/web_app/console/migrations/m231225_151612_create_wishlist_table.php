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
    public function safeUp()
    {
        $this->createTable('{{%wishlist}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'product_id' => $this->integer()->notNull()->unique(),
            'added_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull()
        ]);

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
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-wishlist-user_id}}',
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
