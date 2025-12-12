<?php
/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \app\models\Games $model
 */
?>
<main class="col-10 bg-body">
    <div class="w-100 h-100 pt-2 pb-5 px-5">
        <h1>Quebra-cabeças</h1>
        <div class="card mt-3">
            <div class="card-body p-4">
                <?= \yii\helpers\Html::a('Create new', ['game/create'], ['class' => 'btn mb-3 btn-success']) ?>
                <table class="table table-hover table-bordered rounded-3">
                    <thead>
                    <tr>
                        <th scope="col">Thumbnail</th>
                        <th scope="col">Número de peças</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($dataProvider->getModels() as $model) : ?>
                        <tr>
                            <th>
                                <a href="<?= \yii\helpers\Url::to(['admin/games/' . $model->valid_date]) ?>">
                                    <?= \yii\helpers\Html::img([$model->image_path], ['width' => '150px', 'class' => 'rounded-3']) ?>
                                </a>
                            </th>
                            <td><?= $model->number_pieces ?></td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
                <?= \yii\bootstrap5\LinkPager::widget([
                        'pagination' => $dataProvider->pagination
                ]) ?>
            </div>
        </div>
    </div>
</main>
