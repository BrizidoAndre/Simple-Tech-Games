<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php if (Yii::$app->params['header']): ?>
<div id="home-screen" class="w-100 container-fluid position-relative p-0">
    <div class="row g-0">
        <aside class="col-2 position-fixed top-0 start-0">
            <div class="d-flex flex-column vh-100 p-3 bg-body-tertiary">
                <span class="fs-4">Menu</span>
                <?= Alert::widget() ?>
                <hr>
                <nav>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <?= Html::a('🏠 Home', ['admin/home'], ['class' => 'nav-link link-dark']) ?>
                        </li>
                        <li class="nav-item">
                            <?= Html::a('🙂 Usuários', ['auth/users'], ['class' => 'nav-link link-dark']) ?>
                        </li>
                        <li>
                            <?= Html::a('🧩 Quebra-Cabeças', ['game/index'], ['class' => 'nav-link link-dark']) ?>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="col-2"></div>
        <?php endif ?>
        <?= $content ?>
        <?php if (Yii::$app->params['header']): ?>
    </div>
</div>
<?php endif ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
