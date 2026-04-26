<?php

use yii\db\Migration;

class m260425_090628_add_hashpassword_authkey_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'has_password',$this->string());
        $this->addColumn('{{%users}}', 'auth_key',$this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
     $this->dropColumn('{{%users}}', 'has_password');
     $this->dropColumn('{{%users}}', 'auth_key');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260425_090628_add_hashpassword_authkey_to_users_table cannot be reverted.\n";

        return false;
    }
    */
}
