<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%has_password_from_users}}`.
 */
class m260425_095220_drop_has_password_from_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%users}}', 'has_password');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
$this->addColumn('{{%users}}', 'has_password',$this->string());    }
}
