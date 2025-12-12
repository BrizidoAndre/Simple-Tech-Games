<?php
/**
 * @var \yii\web\View $this
 * @var \app\models\Games[] $games
 * @var \yii\data\ActiveDataProvider $adminProvider
 * @var \app\models\Games[] $gamesPopular
 * @var string $month
 */
?>
<main class="col-10 bg-body">
    <div class="w-100 h-100 pt-2 pb-5 px-5">
        <h1>Home</h1>
        <div class="row gx-3 gy-3 h-100">
            <div class="col-6">
                <div class="card h-100">
                    <div class="card-body p-5">
                        <h2 class="card-title fs-4 mb-3">Últimos jogos</h2>
                        <div class="row gx-2 gy-2">
                            <?php foreach ($games as $i => $item) : ?>
                                <?= $this->render('/game/card_img', [
                                        'item' => $item,
                                        'i' => $i,
                                ]) ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card h-100">
                    <div class="card-body p-5 d-flex align-items-start justify-content-center flex-column">
                        <h2 class="card-title fs-4 mb-3">Novos administradores</h2>
                        <table class="table table-hover table-bordered rounded-3">
                            <thead>
                            <tr>
                                <th scope="col">Email</th>
                                <th scope="col">Telefone</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($adminProvider->getModels() as $admin) : ?>
                                <tr>
                                    <th><a href=""><?= $admin->user->email ?></a></th>
                                    <td><?= $admin->user->phone ?></td>
                                </tr>
                            <?php endforeach ?>
                            </tbody>
                        </table>
                        <?= \yii\bootstrap5\LinkPager::widget([
                                'pagination' => $adminProvider->pagination
                        ]) ?>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card h-100">
                    <div class="card-body p-5">
                        <h2 class="card-title mb-3 fs-4">Jogos populares</h2>
                        <div class="row gx-2 gy-2">
                            <?php foreach ($gamesPopular as $i => $item) : ?>
                                <?= $this->render('/game/card_img', [
                                        'item' => $item,
                                        'i' => $i,
                                ]) ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card h-100">
                    <div class="card-body p-5 d-flex align-items-center flex-column justify-content-center">
                        <h2 class="card-title mb-3 fs-4">Calendário de jogos</h2>
                        <?= $this->render('calendar', [
                                'month' => $month
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
