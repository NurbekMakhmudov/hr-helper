<?php

use yii\db\Migration;

/**
 * Class m211018_051539_insert_default_data
 */
class m211018_051539_insert_default_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql_insert_department = "INSERT INTO `department`(`name`, `status`, `created_at`, `updated_at`) VALUES ('HR', 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());";

        $sql_insert_user = "INSERT INTO `user` (`id`, `username`, `firstname`, `lastname`, `age`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `phone`, `status`, `role`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'Admin', 'Your Name', '', NULL, 'IeIC9zq-eGEFv5Y6XOFWNEbpI__OyxxU', '".'$2y$13$Eqk2yPqbc4Fhio5fC88nNeogk.nk9OLyeDeRF7Oe454agbHo9DhqW'."', NULL, 'admin@gmail.com', '(899)-123-45-67', 10, 'admin', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), 'JKuuWofmT8lzFqaip0Mx9a4umqRct49U_1634495827');";

        $sql_insert_user_to_department = "INSERT INTO `user_to_department`( `user_id`, `department_id`, `created_at`, `updated_at`) VALUES (1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());";


        $this->execute($sql_insert_department);
        $this->execute($sql_insert_user);
        $this->execute($sql_insert_user_to_department);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211018_051539_insert_default_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211018_051539_insert_default_data cannot be reverted.\n";

        return false;
    }
    */
}
