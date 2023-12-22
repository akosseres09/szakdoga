<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m231024_202203_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'description' => $this->string(1024)->notNull(),
            'price' => $this->integer()->notNull(),
            'rating' => $this->integer(),
            'number_of_stocks' => $this->integer()->notNull(),
            'is_activated' => $this->integer(1)->notNull(),
            'is_kid' => $this->integer(1)->notNull(),
            'gender' => $this->integer(1)->notNull()
        ]);

        $this->createIndex(
            '{{%idx-product-name}}',
            '{{%product}}',
            'name'
        );

        $this->createIndex(
            '{{%idx-is-activated}}',
            '{{%product}}',
            'is_activated'
        );

        $this->createIndex(
            '{{%idx-product-price}}',
            '{{%product}}',
            'price'
        );

        $this->createIndex(
        '{{%idx-product-number_of_stocks}}',
        '{{%product}}',
        'number_of_stocks');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('{{%idx-product-name}}', '{{%product}}');
        $this->dropIndex('{{%idx-product-price}}', '{{%product}}');
        $this->dropIndex('{{%idx-product-number_of_stocks}}', '{{%product}}');
        $this->dropIndex('{{%idx-is-activated}}', '{{%product}}');

        $this->dropTable('{{%product}}');
    }
}
