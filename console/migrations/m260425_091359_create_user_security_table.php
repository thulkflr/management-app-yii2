<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_security}}`.
 */
class m260425_091359_create_user_security_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_security}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'reset_password_token'=>$this->string(),
            'failed_login_attempts'=>$this->integer(),
            'last_login_at'=>$this->datetime(),

        ]);
        $this->addForeignKey(
            '{{%fk-user_security-user_id}}',
            '{{%user_security}}',
            'user_id',
            '{{%users}}',
            'id','cascade','cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_security}}');
    }
}
