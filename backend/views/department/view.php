<?php

use backend\models\Department;
use common\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Department */

/* @var $searchModel \backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Departments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="department-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'name',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => Department::getStatusArray(),
                'value' => function (Department $data) {
                    return $data->getStatusName();
                }
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model){
                    return date('d-M-Y h:m:s', $model->created_at);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($model){
                    return date('d-M-Y h:m:s', $model->updated_at);
                }
            ],
        ],
    ]) ?>

    <h1>Users</h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'username',
                'format'=>'raw',
                'value' => function ($model) {
                    return  Html::a($model->username,
                        ['user/view', 'id' => $model->id], ['class' => 'profile-link']);

                }
            ],
            'firstname',
            'lastname',
            'age',
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
        ],
    ]); ?>

</div>
