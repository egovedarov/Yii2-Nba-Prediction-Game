<?php

use kartik\builder\Form;
use kartik\form\ActiveForm;
use kartik\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var UserModel $model
 */

$form = ActiveForm::begin(
    [
        'method' => 'POST'
    ]
);

echo Form::widget([
    'model' => $model,
    'form' => $form,
    'attributes' => [
        'username' => [
            'type' => Form::INPUT_TEXT,
            'options' => ['placeholder' => 'Enter username...']
        ],
        'password' => [
            'type' => Form::INPUT_PASSWORD,
            'options' => ['placeholder' => 'Enter password...']
        ],
        'actionsLogin' => [
            'type' => Form::INPUT_RAW,
            'value' => Html::submitButton(\Yii::t('app', 'Login'), ['class' => 'btn btn-primary']) . ' '
                . Html::a(' Register', ['/users/register'], ['class' => 'btn btn-primary'])
        ]
    ]
]);

ActiveForm::end();