<?php

namespace backend\forms;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Create User form
 */
class CreateUserForm extends Model
{
    public $id;
    public $username;
    public $firstname;
    public $lastname;
    public $age;
    public $auth_key;
    public $password_hash;
    public $password_reset_token;
    public $email;
    public $phone;
    public $status;
    public $role;
    public $created_at;
    public $updated_at;
    public $verification_token;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['phone', 'trim'],
            ['phone', 'required'],
            ['phone', 'string', 'max' => 15],
            ['phone', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This phone number has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            [['status', 'role'], 'required'],
        ];
    }

    /**
     * @return $this|null
     */
    public function createUser()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->age = $this->age;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->status = $this->status;
        $user->role = $this->role;

        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        $user->created_at = time();
        $user->updated_at = time();

        if ($user->validate() && $user->save()){
            $this->id = $user->id;
            return $this;
        }

        return null;
    }


}
