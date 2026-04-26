<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%password_phon_surname_from_users}}`.
 */
class m260425_090222_drop_password_phon_surname_from_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%users}}', 'surname');
        $this->dropColumn('{{%users}}', 'phone');
        $this->dropColumn('{{%users}}', 'password');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%users}}', 'surname',$this->string());
        $this->addColumn('{{%users}}', 'phone',$this->string());
        $this->addColumn('{{%users}}', 'password',$this->string());
    }
}
