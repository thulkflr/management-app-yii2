<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ideas}}`.
 */
class m260423_102902_create_ideas_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ideas}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'owner_name' => $this->string()->notNull(),
            'idea_name' => $this->string()->notNull(),
            'idea_type' => $this->string()->notNull(),
            'idea_description' => $this->string()->notNull(),
            'url' => $this->string(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);
        $this->addForeignKey(
            'fk-ideas-owner',
            '{{%ideas}}',
            'user_id',
            '{{%users}}',
            'id',
            'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ideas}}');
    }
}
