<?php
/**
 * @var int $i
 * @var \app\models\Games $item
 */
?>
<div class="col-6">
    <a class="game-card rounded-3" href="<?= \yii\helpers\Url::to(['game/view', 'date' => $item->valid_date]) ?>">
        <figure>
            <?= \yii\helpers\Html::img([$item->image_path]) ?>
            <figcaption>
                <h3 class="fs-5">Jogo <?= ($i + 1) ?></h3>
                <span>Data: <?= Yii::$app->formatter->asDate($item->valid_date, 'php:d/m/Y') ?></span>
                <p>Pontos:<?= $item->popCount ?></p>
            </figcaption>
        </figure>
    </a>
</div>
