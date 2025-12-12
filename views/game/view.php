<?php
/**
 * @var \app\models\Games $model
 */
?>
<main class="col-10 bg-body">
    <div class="w-100 h-100 pt-2 pb-5 px-5">
        <h1>Quebra-cabeça do dia <?= Yii::$app->formatter->asDate($model->valid_date, 'php:d/m/Y') ?></h1>
        <span><?= $model->number_pieces ?> peças</span>
        <div class="card mt-3">
            <div class="card-body p-4">
                <h2>Game GRID</h2>
                <div class="grid-game" style="--count: <?= sqrt($model->number_pieces) ?>">
                    <?php foreach ($model->pieces as $piece) : ?>
                        <?= \yii\helpers\Html::img([$piece->url], ['alt' => $piece->position, 'class' => 'w-100 h-100 object-fit-cover']) ?>
                    <?php endforeach ?>
                </div>
                <br>
                <h2>Logs de pontos</h2>
                <table class="table table-hover align-middle table-bordered rounded-3">
                    <thead>
                    <tr>
                        <th scope="col">Email do jogador</th>
                        <th scope="col">Tempo de execução</th>
                        <th scope="col">Data da resolução</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th><a href="">email@email.com</a></th>
                        <td>00:03:21</td>
                        <td>02/01/2026</td>
                    </tr>
                    <tr>
                        <th><a href="">email@email.com</a></th>
                        <td>00:03:21</td>
                        <td>02/01/2026</td>
                    </tr>
                    <tr>
                        <th><a href="">email@email.com</a></th>
                        <td>00:03:21</td>
                        <td>02/01/2026</td>
                    </tr>
                    <tr>
                        <th><a href="">email@email.com</a></th>
                        <td>00:03:21</td>
                        <td>02/01/2026</td>
                    </tr>
                    <tr>
                        <th><a href="">email@email.com</a></th>
                        <td>00:03:21</td>
                        <td>02/01/2026</td>
                    </tr>
                    <tr>
                        <th><a href="">email@email.com</a></th>
                        <td>00:03:21</td>
                        <td>02/01/2026</td>
                    </tr>
                    <tr>
                        <th><a href="">email@email.com</a></th>
                        <td>00:03:21</td>
                        <td>02/01/2026</td>
                    </tr>
                    <tr>
                        <th><a href="">email@email.com</a></th>
                        <td>00:03:21</td>
                        <td>02/01/2026</td>
                    </tr>
                    <tr>
                        <th><a href="">email@email.com</a></th>
                        <td>00:03:21</td>
                        <td>02/01/2026</td>
                    </tr>
                    <tr>
                        <th><a href="">email@email.com</a></th>
                        <td>00:03:21</td>
                        <td>02/01/2026</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
