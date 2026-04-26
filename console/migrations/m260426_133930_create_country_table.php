<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%country}}`.
 */
class m260426_133930_create_country_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%country}}', [
            'id' => $this->smallInteger(5)->unsigned()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'name' => $this->string(70)->notNull(),
            'name_ar' => $this->string(70),
            'iso2' => $this->string(2),
            'country_code' => $this->string(5)->notNull(),
            'order' => $this->bigInteger()->notNull()->defaultValue(0),
        ], $tableOptions);


        $this->createIndex('id_2', '{{%country}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%country}}');
    }
}
