<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string|null $firstname
 * @property string|null $lastname
 * @property int|null $age
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string|null $email
 * @property string|null $phone
 * @property int $status
 * @property string $role
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 *
 * @property UserToDepartment[] $userToDepartments
 */
class User extends \common\models\User
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'phone', 'email', 'auth_key', 'password_hash', 'role', 'created_at', 'updated_at'], 'required'],
            [['age', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'firstname', 'lastname', 'password_hash', 'password_reset_token', 'email', 'phone', 'role', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['email'], 'unique'],
            [['phone'], 'unique'],
        ];
    }


    /**
     * Gets query for [[UserToDepartments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserToDepartments()
    {
        return $this->hasMany(UserToDepartment::className(), ['user_id' => 'id']);
    }
}
