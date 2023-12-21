<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%type}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%product}}`
 */
class m231221_120105_create_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%type}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'type' => $this->string(32)->notNull(),
        ]);

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-type-product_id}}',
            '{{%type}}',
            'product_id'
        );

        $this->createIndex(
            '{{%idx-type-type}}',
            '{{%type}}',
            'type');

        // add foreign key for table `{{%product}}`
        $this->addForeignKey(
            '{{%fk-type-product_id}}',
            '{{%type}}',
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
        // drops foreign key for table `{{%product}}`
        $this->dropForeignKey(
            '{{%fk-type-product_id}}',
            '{{%type}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-type-product_id}}',
            '{{%type}}'
        );

        $this->dropIndex('{{%idx-type-type}}',
            '{{%type}}');

        $this->dropTable('{{%type}}');
    }
}
