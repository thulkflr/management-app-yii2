<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_settings}}`.
 */
class m260425_091417_create_user_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_settings}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'language' => $this->string()->notNull(),
            'dark_mode' => $this->boolean()->notNull()->defaultValue(0),
            'enable_notification' => $this->boolean()->notNull()->defaultValue(0),
        ]);
        $this->addForeignKey(
            'fk_user_settings_user_id',
            'user_settings',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_settings}}');
    }
}
