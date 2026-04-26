<?php

use yii\db\Migration;

class m260425_090827_change_constraint_created_updated_at_of_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%users}}', 'updated_at', $this->datetime());
        $this->alterColumn('{{%users}}', 'created_at', $this->datetime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->alterColumn('{{%users}}', 'updated_at', $this->integer());
       $this->alterColumn('{{%users}}', 'created_at', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260425_090827_change_constraint_created_updated_at_of_users_table cannot be reverted.\n";

        return false;
    }
    */
}
