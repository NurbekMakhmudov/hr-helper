<?php

use backend\models\Department;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Department */

$this->title = Yii::t('app', 'Создать отдел');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Отделы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-create">

    <?php if (!Department::departmentsExists()): ?>

    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Нет ни одного отдел!</strong> сначала нужно создать отдел.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
