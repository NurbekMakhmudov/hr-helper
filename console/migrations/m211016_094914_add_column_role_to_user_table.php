<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m211016_094914_add_column_role_to_user_table
 */
class m211016_094914_add_column_role_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(User::tableName(), 'role', $this->string()->notNull()->after('status'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211016_094914_add_column_role_to_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211016_094914_add_column_role_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
