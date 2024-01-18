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
    public function safeUp()
    {
        $this->createTable('{{%brand}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
        ]);

        $this->createIndex('{{%idx-brand-name}}',
        '{{%brand}}',
        'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            '{{%idx-brand-name}}',
            '{{%brand}}');
        $this->dropTable('{{%brand}}');
    }
}
