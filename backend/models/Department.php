<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

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
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @param null $status
     * @return array|mixed
     */
    public static function getStatusArray($status = null)
    {
        $array = [
            self::STATUS_ACTIVE => Yii::t('app', 'ACTIVE'),
            self::STATUS_INACTIVE => Yii::t('app', 'INACTIVE'),
        ];
        return $status === null ? $array : $array[$status];
    }

    /**
     * @return string
     */
    public function getStatusName()
    {
        $array = [
            self::STATUS_ACTIVE => '<b style="color: blue">' . self::getStatusArray(self::STATUS_ACTIVE) . '</b>',
            self::STATUS_INACTIVE => '<b style="color: red">' . self::getStatusArray(self::STATUS_INACTIVE) . '</b>',
        ];

        return isset($array[$this->status]) ? $array[$this->status] : '';
    }

    /**
     * check departments if exists
     *
     * @return bool
     */
    public static function departmentsExists(){
        return Department::find()->exists();
    }

    /**
     * get department names with id
     *
     * @return array
     */
    public static function getDepartmentsNames()
    {
        $departments = Department::find()
            ->select(['id', 'name'])
            ->asArray()
            ->all();

        $result = ArrayHelper::map($departments, 'id', 'name');;

        return $result;
    }


}
