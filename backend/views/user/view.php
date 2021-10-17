<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'department',
                'format'=>'raw',
                'value' => function ($model) {
                    return  Html::a($model->userToDepartments[0]->department->name,
                        ['department/view', 'id' => $model->userToDepartments[0]->department->id], ['class' => 'profile-link']);

                }
            ],
            'username',
            'firstname',
            'lastname',
            'age',
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
            'email:email',
            'phone',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => User::getStatusArray(),
                'value' => function (User $data) {
                    return $data->getStatusName();
                }
            ],
            'role',
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date('d-M-Y h:m:s', $model->created_at);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return date('d-M-Y h:m:s', $model->updated_at);
                }
            ],
//            'verification_token',
        ],
    ]) ?>

</div>
