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
    public function safeUp(): void
    {
        $this->createTable('{{%type}}', [
            'name' => $this->string(128)->notNull()
        ]);

        $this->addPrimaryKey('{{%idx-type-name}}',
            '{{%type}}',
        'name');

        $this->insert('{{%type}}', [
            'name' => 'Accessories'
        ]);

        $this->insert('{{%type}}', [
            'name' => 'Gloves'
        ]);

        $this->insert('{{%type}}', [
            'name' => 'Handball Shoes'
        ]);

        $this->insert('{{%type}}', [
            'name' => 'Indoor Football Shoes'
        ]);

        $this->insert('{{%type}}', [
            'name' => 'Outdoor Football Shoes'
        ]);

        $this->insert('{{%type}}', [
            'name' => 'Shoes'
        ]);

        $this->insert('{{%type}}', [
            'name' => 'Shirt'
        ]);

        $this->insert('{{%type}}', [
            'name' => 'Basketball Shoes'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropPrimaryKey(
        '{{%idx-type-name}}',
        '{{%type}}');

        $this->dropTable('{{%type}}');
    }
}
