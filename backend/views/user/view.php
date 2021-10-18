<?php

use backend\models\Department;
use common\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model User */

/* @var $searchModel backend\models\DepartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Пользовател'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1>Пользовател <?= $this->title ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Добавить отдел'), ['add-department', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
        <?= Html::a(Yii::t('app', 'Обновлять'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if (!$model->isAdmin()): ?>
            <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Вы уверены, что хотите удалить этот элемент?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
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

        ],
    ]) ?>

    <h2><?= Yii::t('app', 'Информация отдела') ?></h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->name,
                        ['department/view', 'id' => $model->id], ['class' => 'profile-link']);

                }
            ],
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

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        return Html::a('<svg aria-hidden="true" style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:.875em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V128H32zm272-256a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zM432 32H312l-9-19a24 24 0 00-22-13H167a24 24 0 00-22 13l-9 19H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16z"/></svg>',
                            $url, [
                                'title' => Yii::t('app', 'Delete ' . $model->name),
                                'data' => [
                                    'confirm' => 'Вы уверены, что хотите удалить данные?',
                                ],
                            ]);
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'delete') {
                        $url = 'delete-department-from-user?id=' . Yii::$app->request->get('id') . '&department_id=' . $model->id;
                        return $url;
                    }
                }
            ],

        ],
    ]); ?>

</div>
