<?php
/**
 * @var \app\models\Users $model
 * @var bool $success
 * @var \app\models\FirstAccess|bool $link
 */
$javascriptLink = 'http://172.16.21.47/modulo_b_BR_v2/auth/first-access?link=' . $link?->link;
?>
<main class="col-10 bg-body">
    <div class="w-100 h-100 pt-2 pb-5 px-5">
        <h1>Novo Usuário (admin)</h1>
        <div class="card mt-3">
            <div class="card-body p-4">

                <?php $form = \yii\widgets\ActiveForm::begin() ?>
                <div class="mb-3">
                    <?= \yii\helpers\Html::activeLabel($model, 'email') ?>
                    <?= \yii\helpers\Html::activeInput('email', $model, 'email', ['class' => 'form-control']) ?>
                    <?= \yii\helpers\Html::error($model, 'email') ?>
                </div>
                <div class="mb-3">
                    <?= \yii\helpers\Html::activeLabel($model, 'name') ?>
                    <?= \yii\helpers\Html::activeInput('text', $model, 'name', ['class' => 'form-control']) ?>
                    <?= \yii\helpers\Html::error($model, 'name') ?>
                </div>
                <div class="mb-3">
                    <?= \yii\helpers\Html::activeLabel($model, 'phone') ?>
                    <?= \yii\helpers\Html::activeInput('text', $model, 'phone', ['class' => 'form-control']) ?>
                    <?= \yii\helpers\Html::error($model, 'phone') ?>
                </div>
                <button class="btn btn-primary">Cadastrar</button>
                <?php \yii\widgets\ActiveForm::end() ?>

                <?php if ($success && $link): ?>
                    <p class="link">Usuário cadastrado: <span id="link"><?= $javascriptLink ?></span></p>
                    <button id="copy" class="btn btn-secondary">Copiar</button>
                <?php endif ?>
            </div>
        </div>
    </div>
</main>

<script>
    copy.addEventListener('click', async (ev) => {
        await navigator.clipboard.writeText("<?= $javascriptLink?>");
    })
</script>
