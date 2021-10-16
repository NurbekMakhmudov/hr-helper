<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_to_department}}`.
 */
class m211016_051301_create_user_to_department_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_to_department}}', [
            'user_id' => $this->integer()->notNull(),
            'department_id' => $this->integer()->notNull(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('FK_user_to_department_ad_user', 'user_to_department', 'user_id',
            'user', 'id');

        $this->addForeignKey('FK_user_to_department_ad_department', 'user_to_department', 'department_id',
            'department', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_to_department}}');
    }
}
