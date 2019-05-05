<?php

use app\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var string $content
 */

?>

<?php $this->beginContent('@app/views/layouts/base.php') ?>

<div class="container">
    <?= !empty($this->title) ? Html::tag('h1', $this->title) : '' ?>
    <?= $content ?>
</div>

<?php $this->endContent() ?>