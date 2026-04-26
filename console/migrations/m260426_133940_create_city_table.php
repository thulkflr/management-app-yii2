<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%city}}`.
 */
class m260426_133940_create_city_table extends Migration
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

        $this->createTable('{{%city}}', [
            'id' => $this->smallInteger(5)->unsigned()->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'name' => $this->string(70)->notNull(),
            'name_ar' => $this->string(70),
            'country_id' => $this->smallInteger(5)->unsigned()->notNull(),
        ], $tableOptions);

        $this->createIndex('id_2', '{{%city}}', 'id');
        $this->createIndex('country_id', '{{%city}}', 'country_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%city}}');
    }
}
