<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_profile}}`.
 */
class m260425_091342_create_user_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_profile}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'city_id' => $this->integer()->notNull(),
            'country_id' => $this->integer()->notNull(),
            'avatar' => $this->string()->notNull(),
            'bio' => $this->text()->notNull(),
        ]);
        $this->addForeignKey(
            'fk-user_profile-user_id',
            'user_profile',
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
        $this->dropTable('{{%user_profile}}');
    }
}
