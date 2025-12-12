<?php
/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 *
 * @var \app\models\Users $model
 */
function activeBtn($value)
{
    $param = Yii::$app->request->getQueryParam('players', 0);
    if ($param == $value) {
        return 'active';
    }
    return '';
}

?>
<main class="col-10 bg-body">
    <div class="w-100 h-100 pt-2 pb-5 px-5">
        <h1>Usuários</h1>
        <div class="btn-group">
            <?= \yii\helpers\Html::a('Admins', ['', 'players' => 0], ['class' => 'btn btn-primary ' . activeBtn(0)]) ?>
            <?= \yii\helpers\Html::a('Players', ['', 'players' => 1], ['class' => 'btn btn-primary ' . activeBtn(1)]) ?>
        </div>
        <div class="card mt-3">
            <div class="card-body p-4">
                <?= \yii\helpers\Html::a('Create new', ['auth/new-user'], ['class' => 'btn btn-success mb-3']) ?>
                <table class="table table-hover table-bordered rounded-3">
                    <thead>
                    <?php if (activeBtn(1)): ?>
                        <tr>
                            <th scope="col">Email</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Deletado?</th>
                            <th scope="col">link para perfil</th>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <th scope="col">Email</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Primeiro acesso realizado?</th>
                            <th scope="col">link para perfil</th>
                        </tr>
                    <?php endif ?>
                    </thead>
                    <tbody>
                    <?php if (activeBtn(1)): ?>
                        <?php foreach ($dataProvider->getModels() as $id => $model): ?>
                            <tr>
                                <th><a href=""><?= $model->email ?></a></th>
                                <td><?= $model->name ?></td>
                                <td><?= $model->phone ?></td>
                                <?php if ($model->players && $model->players->deleted): ?>
                                    <td><span class="badge text-bg-success">Sim</span></td>
                                <?php else: ?>
                                    <td><span class="badge text-bg-danger">Não</span></td>
                                <?php endif ?>
                                <td><?= \yii\helpers\Html::a('Perfil', ["admin/profile/player/$model->id"], ['class' => 'text-primary']) ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <?php foreach ($dataProvider->getModels() as $id => $model): ?>
                            <tr>
                                <th><a href=""><?= $model->email ?></a></th>
                                <td><?= $model->name ?></td>
                                <td><?= $model->phone ?></td>
                                <?php if ($model->admins && !$model->admins->first_acess): ?>
                                    <td><span class="badge text-bg-success">Sim</span></td>
                                <?php else: ?>
                                    <td><span class="badge text-bg-danger">Não</span></td>
                                <?php endif ?>
                                <td><?= \yii\helpers\Html::a('Perfil', ["admin/profile/admin/$model->id"], ['class' => 'text-primary']) ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                    </tbody>
                </table>
                <?= \yii\bootstrap5\LinkPager::widget([
                        'pagination' => $dataProvider->pagination
                ]) ?>
            </div>
        </div>
    </div>
</main>
