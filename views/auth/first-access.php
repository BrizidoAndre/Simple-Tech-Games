<?php

/**
 * @var \app\models\UsersPassword $model
 */
?>
<main id="login-screen"
      class="min-vh-100 vw-100 pt-2 pb-5 px-2 bg-body-secondary d-flex align-items-center justify-content-center">
    <div id="login-form" class="bg-light border-1 border rounded-2">
        <?php $form = \yii\widgets\ActiveForm::begin(['options' => ['class' => 'container-fluid p-5']]) ?>
        <h1>Primeiro Acesso</h1>
        <div class="mt-3">
            <?= \yii\helpers\Html::activeLabel($model, 'password') ?>
            <?= \yii\helpers\Html::activeInput('password', $model, 'password', ['class' => 'form-control']) ?>
            <?= \yii\helpers\Html::error($model, 'password') ?>
        </div>
        <div class="mt-3">
            <?= \yii\helpers\Html::activeLabel($model, 'passwordConfirm') ?>
            <?= \yii\helpers\Html::activeInput('password', $model, 'passwordConfirm', ['class' => 'form-control']) ?>
            <?= \yii\helpers\Html::error($model, 'passwordConfirm') ?>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
        <?php \yii\widgets\ActiveForm::end() ?>
    </div>
</main>
