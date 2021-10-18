<?php

use backend\forms\ChangePasswordForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model ChangePasswordForm */
/* @var $form ActiveForm */

$this->title = 'Измени пароль';
?>
<div class="user-changePassword">

   <h1> <?= Yii::t('app', $this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'password')->passwordInput()->label(Yii::t('app', 'Пароль')) ?>
    <?= $form->field($model, 'confirm_password')->passwordInput()->label(Yii::t('app', 'Подтвердите пароль')) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Изменять'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>