<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%brands}}`.
 */
class m231222_121544_create_brands_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%brand}}', [
            'name' => $this->string(128)->notNull(),
        ]);

        $this->addPrimaryKey('{{%pk-brand-name}}', '{{%brand}}', 'name');

        $this->insert('{{%brand}}',[
            'name' => 'Adidas'
        ]);
        $this->insert('{{%brand}}',[
            'name' => 'Heavy Tools'
        ]);
        $this->insert('{{%brand}}',[
            'name' => 'New Balance'
        ]);
        $this->insert('{{%brand}}',[
            'name' => 'Nike'
        ]);
        $this->insert('{{%brand}}',[
            'name' => 'Puma'
        ]);
        $this->insert('{{%brand}}',[
            'name' => 'Umbro'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropPrimaryKey(
            '{{%idx-brand-name}}',
            '{{%brand}}');
        $this->dropTable('{{%brand}}');
    }
}
