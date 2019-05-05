<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;

?>

<?php $this->beginContent('@app/views/layouts/base.php') ?>

<div class="wrap">
    <?= $this->render('../menu') ?>

    <div class="container">
        <?= !empty($this->title) ? Html::tag('h1', $this->title) : '' ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<?= $this->render('../footer') ?>

<?php $this->endContent() ?>