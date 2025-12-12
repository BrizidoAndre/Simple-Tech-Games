<?php
/**
 * @var \app\models\Users $model
 * @var \app\models\Solution $solution
 */
?>
<main class="col-10 bg-body">
    <div class="w-100 h-100 pt-2 pb-5 px-5">
        <h1><?= $model->name ?> (<?= $model->email ?>)</h1>
        <span><?= $model->phone ?></span>
        <div class="card mt-3">
            <div class="card-body p-4">
                <?= \yii\helpers\Html::a('Deletar usuário', ['auth/player-delete', 'id' => $model->id], [
                        'class' => 'btn mb-3 btn-danger'
                ]) ?>
                <h2>Logs de pontos</h2>
                <table class="table table-hover align-middle table-bordered rounded-3">
                    <thead>
                    <tr>
                        <th scope="col">Thumbnail</th>
                        <th scope="col">Data do jogo</th>
                        <th scope="col">Data da resolução</th>
                        <th scope="col">Tempo da resolução</th>
                        <th scope="col">Número de peças</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($model->players->solutions as $solution) : ?>
                        <tr>
                            <th><a href="">
                                    <?= \yii\helpers\Html::img([$solution->game->image_path], ['class' => 'rounded-3', 'width' => '150']) ?>
                                </a></th>
                            <td><?= Yii::$app->formatter->asDate($solution->game->date, 'php:d/m/Y') ?></td>
                            <td><?= Yii::$app->formatter->asDate($solution->resolution_date, 'php:d/m/Y') ?></td>
                            <td>
                                <?= Yii::$app->formatter->asTime($solution->time_taken, 'php:H:i:s') ?>
                            </td>
                            <td><?= $solution->game->number_pieces ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
