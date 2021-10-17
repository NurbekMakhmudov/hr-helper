<?php

namespace common\models;

use backend\models\UserToDepartment;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $firstname
 * @property string $lastname
 * @property integer $age
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $phone
 * @property string $auth_key
 * @property integer $status
 * @property string $role
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property UserToDepartment[] $userToDepartments
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    const ROLE_ADMIN = 'admin';
    const ROLE_CLIENT = 'client';

    public $password;
    public $department;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'firstname' => Yii::t('app', 'Имя пользователя'),
            'lastname' => Yii::t('app', 'Lastname'),
            'age' => Yii::t('app', 'Age'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'status' => Yii::t('app', 'Status'),
            'role' => Yii::t('app', 'Role'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'verification_token' => Yii::t('app', 'Verification Token'),
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['department', 'username', 'phone', 'email', 'auth_key', 'password_hash', 'role', 'created_at', 'updated_at'], 'required'],
            [['age', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'firstname', 'lastname', 'password_hash', 'password_reset_token', 'email', 'phone', 'role', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['email'], 'unique'],
            [['phone'], 'unique'],

            [['password'], 'required', 'on' => self::SCENARIO_CREATE],

            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_CREATE] = ['username', 'department', 'password', 'role',
            'firstname', 'lastname', 'age', 'password_reset_token', 'email', 'phone', 'status'];

        $scenarios[self::SCENARIO_UPDATE] = ['username', 'department', 'password', 'role',
            'firstname', 'lastname', 'age', 'password_reset_token', 'email', 'phone', 'status'];

        return $scenarios;
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


    /**
     * role
     */
    public static function getRoleArray($role = null)
    {
        $array = [
            self::ROLE_CLIENT => Yii::t('app', 'CLIENT'),
            self::ROLE_ADMIN => Yii::t('app', 'ADMIN'),
        ];
        return $role === null ? $array : $array[$role];
    }

    /**
     * @return string
     */
    public function getRoleName()
    {
        $array = [
            self::ROLE_CLIENT => '<b style="color: lightskyblue">' . self::getRoleArray(self::ROLE_CLIENT) . '</b>',
            self::ROLE_ADMIN => '<b style="color: red">' . self::getRoleArray(self::ROLE_ADMIN) . '</b>',
        ];

        return isset($array[$this->role]) ? $array[$this->role] : '';
    }


    /**
     * Status
     */
    public static function getStatusArray($status = null)
    {
        $array = [
            self::STATUS_INACTIVE => Yii::t('app', 'INACTIVE'),
            self::STATUS_ACTIVE => Yii::t('app', 'ACTIVE'),
//            self::STATUS_DELETED => Yii::t('app', 'DELETED'),
        ];
        return $status === null ? $array : $array[$status];
    }

    /**
     * @return string
     */
    public function getStatusName()
    {
        $array = [
            self::STATUS_INACTIVE => '<b style="color: red">' . self::getStatusArray(self::STATUS_INACTIVE) . '</b>',
            self::STATUS_ACTIVE => '<b style="color: blue">' . self::getStatusArray(self::STATUS_ACTIVE) . '</b>',
//            self::STATUS_DELETED => '<b style="color: yellow">' . self::getStatusArray(self::STATUS_DELETED) . '</b>',
        ];

        return isset($array[$this->status]) ? $array[$this->status] : '';
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Access for client, admin
     * @return bool
     */
    public function isClient()
    {
        if ($this->role === self::ROLE_CLIENT || $this->role === self::ROLE_ADMIN)
            return true;

        return false;
    }

    /**
     * Access for admin
     * @return bool
     */
    public function isAdmin()
    {
        if ($this->role === self::ROLE_ADMIN)
            return true;

        return false;
    }

    /**
     * Create a new user
     * @return User|null
     */
    public function createUser()
    {
        $this->setPassword($this->password);
        $this->generateAuthKey();
        $this->generateEmailVerificationToken();
        $this->created_at = time();
        $this->updated_at = time();

        if ($this->save()) {

            $userToDepartment = new UserToDepartment();
            $userToDepartment->department_id = $this->department;
            $userToDepartment->user_id = $this->id;
            $userToDepartment->created_at = time();
            $userToDepartment->updated_at = time();

            if ($userToDepartment->save())
                return $this;
        }

        return null;
    }

    /**
     * Update a  user
     * @return User|null
     */
    public function updateUser()
    {
        $this->updated_at = time();
        if ($this->save()) {

            /** @var UserToDepartment $userToDepartment */
            $userToDepartment = UserToDepartment::find()
                ->where([
                    'user_id' => $this->id
                ])
                ->andWhere([
                    'department_id' => $this->userToDepartments[0]->department_id
                ])
                ->one();

            $userToDepartment->department_id = $this->department;
            $userToDepartment->user_id = $this->id;
            $userToDepartment->updated_at = time();

            if ($userToDepartment->save())
                return $this;

        }

        return null;
    }


}
