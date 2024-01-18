<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m231222_124806_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'description_title' => $this->string(128)->notNull(),
            'description' => $this->string(1024)->notNull(),
            'price' => $this->integer()->notNull(),
            'details' => $this->string(1024)->notNull(),
            'number_of_stocks' => $this->integer()->notNull(),
            'is_activated' => $this->integer(1)->notNull(),
            'is_kid' => $this->integer(1)->notNull(),
            'gender' => $this->integer(1)->notNull(),
            'folder_id' => $this->string(11)->notNull(),
            'brand_id' => $this->integer()->notNull(),
            'type_id' => $this->integer()->notNull(),
            'rating' => $this->integer(),
        ]);

        $this->createIndex('{{%idx-product-brand_id}}',
            '{{product}}',
            'brand_id'
        );

        $this->createIndex('{{%idx-product-type_id}}',
            '{{product}}',
            'type_id'
        );

        $this->addForeignKey(
            '{{%fk-product-type_id}}',
            '{{%product}}',
            'type_id',
            '{{%type}}',
            'id',
            'NO ACTION',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-product-brand_id}}',
            '{{%product}}',
            'brand_id',
            '{{%brand}}',
            'id',
            'NO ACTION',
            'CASCADE'
        );

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

        $this->createIndex('{{%idx-product-is_kid}}',
            '{{%product}}',
            'is_kid');

        $this->createIndex('{{%idx-product-gender}}',
            '{{%product}}',
            'gender');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-product-brand_id}}',
            '{{%product}}'
        );

        $this->dropForeignKey(
        '{{%fk-product-type_id}}',
        '{{%product}}');

        $this->dropIndex('{{%idx-product-type_id}}', '{{%product}}');
        $this->dropIndex('{{%idx-product-brand_id}}','{{%product}}');
        $this->dropIndex('{{%idx-product-name}}', '{{%product}}');
        $this->dropIndex('{{%idx-product-price}}', '{{%product}}');
        $this->dropIndex('{{%idx-product-number_of_stocks}}', '{{%product}}');
        $this->dropIndex('{{%idx-is-activated}}', '{{%product}}');
        $this->dropIndex('{{%idx-product-gender}}','{{%product}}');
        $this->dropIndex('{{%idx-product-is_kid}}','{{%product}}');

        $this->dropTable('{{%product}}');
    }
}
