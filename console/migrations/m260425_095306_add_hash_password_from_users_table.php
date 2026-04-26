<?php

use yii\db\Migration;

class m260425_095306_add_hash_password_from_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
            $this->addColumn('{{%users}}', 'hash_password',$this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'hash_password');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260425_095306_add_hash_password_from_users_table cannot be reverted.\n";

        return false;
    }
    */
}
