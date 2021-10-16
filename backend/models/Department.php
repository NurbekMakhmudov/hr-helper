<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property UserToDepartment[] $userToDepartments
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[UserToDepartments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserToDepartments()
    {
        return $this->hasMany(UserToDepartment::className(), ['department_id' => 'id']);
    }

    /**
     * Status
     */
    const STATUS_IN_ACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public static function getStatusArray($status = null)
    {
        $array = [
            self::STATUS_IN_ACTIVE => Yii::t('app', 'IN ACTIVE'),
            self::STATUS_ACTIVE => Yii::t('app', 'ACTIVE'),
        ];
        return $status === null ? $array : $array[$status];
    }

    public function getStatusName()
    {
        $array = [
            self::STATUS_ACTIVE => '<span class="text-bold text-light-blue">' . self::getStatusArray(self::STATUS_ACTIVE) . '</span>',
            self::STATUS_IN_ACTIVE => '<span class="text-bold text-red">' . self::getStatusArray(self::STATUS_IN_ACTIVE) . '</span>',
        ];

        return isset($array[$this->status]) ? $array[$this->status] : '';
    }

}
