<?php

use backend\models\Department;
use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \common\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Добавить отдел');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Пользовател'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="add-department">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'department')->dropDownList(Department::getDepartmentsNames(),
        ['options' => [$model->userToDepartments[0]->department->id => ['Selected' => true]]]
    )->label(Yii::t('app', 'Отдел')) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Назад'), ['view', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
