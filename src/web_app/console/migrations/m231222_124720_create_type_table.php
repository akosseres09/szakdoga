<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%type}}`.
 */
class m231222_124720_create_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%type}}', [
            'id' => $this->primaryKey(),
            'product_type' => $this->string(128)->notNull()
        ]);

        $this->createIndex('{{%idx-type-product_type}}',
            '{{%type}}',
        'product_type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
        '{{%idx-type-product_type}}',
        '{{%type}}');

        $this->dropTable('{{%type}}');
    }
}
