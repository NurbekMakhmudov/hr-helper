<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4"><?= Yii::$app->name ?></h1>

        <p class="lead"><?= Yii::t('app',
                'это комплексная HRM система для управления HR. Все данные по каждому сотруднику и кандидату теперь под рукой.') ?></p>

        <hr>

        <p><?= Yii::t('app', 'Для начала работа добавьте отделы, потом пользователь !') ?></p>

    </div>

    <div class="body-content">


    </div>
</div>
