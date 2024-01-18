<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rating}}`.
 */
class m231222_125014_create_rating_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rating}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'rating' => $this->integer()->notNull(),
            'description' => $this->string(2048),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-rating-user_id}}',
            '{{%rating}}',
            'user_id'
        );

        // add foreign key for table `{{%User}}`
        $this->addForeignKey(
            '{{%fk-rating-user_id}}',
            '{{%rating}}',
            'user_id',
            '{{%User}}',
            'id',
            'CASCADE'
        );

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-rating-product_id}}',
            '{{%rating}}',
            'product_id'
        );

        // add foreign key for table `{{%Product}}`
        $this->addForeignKey(
            '{{%fk-rating-product_id}}',
            '{{%rating}}',
            'product_id',
            '{{%Product}}',
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
            '{{%fk-rating-user_id}}',
            '{{%rating}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-rating-user_id}}',
            '{{%rating}}'
        );

        // drops foreign key for table `{{%Product}}`
        $this->dropForeignKey(
            '{{%fk-rating-product_id}}',
            '{{%rating}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-rating-product_id}}',
            '{{%rating}}'
        );

        $this->dropTable('{{%rating}}');
    }
}
