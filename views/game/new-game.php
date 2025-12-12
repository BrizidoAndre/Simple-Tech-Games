<?php

/**
 * @var \app\models\Games $model
 */
?>
<main class="col-10 bg-body">
    <div class="w-100 h-100 pt-2 pb-5 px-5">
        <h1>Novo Quebra-cabeça</h1>
        <div class="card mt-3">
            <div class="card-body p-4">
                <?php $form = \yii\widgets\ActiveForm::begin() ?>
                <?= $form->field($model, 'valid_date')->input('date') ?>
                <div class="mb-3">
                    <label for="pieces" class="form-label">Número de peças</label>
                    <select class="form-control" id="pieces" name="Games[number_pieces]">
                        <option>4</option>
                        <option>9</option>
                        <option>16</option>
                        <option>25</option>
                        <option>36</option>
                        <option>49</option>
                        <option>64</option>
                        <option>81</option>
                        <option>100</option>
                    </select>
                    <?= \yii\helpers\Html::error($model, 'number_pieces') ?>
                </div>
                <?= $form->field($model, 'imageFile')->fileInput() ?>
                <button class="btn btn-primary">Cadastrar</button>
                <?php \yii\widgets\ActiveForm::end() ?>
            </div>
        </div>
    </div>
</main>
