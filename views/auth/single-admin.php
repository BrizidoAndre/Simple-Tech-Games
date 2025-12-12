<?php
/**
 * @var \app\models\Users $model
 * @var \app\models\FirstAccess $link
 */

$javascriptLink = 'http://172.16.21.47/modulo_b_BR_v2/auth/first-access?link=' . $link?->link;
?>
<main class="col-10 bg-body">
    <div class="w-100 h-100 pt-2 pb-5 px-5">
        <h1><?= $model->name ?> (<?= $model->email ?>)</h1>
        <span><?= $model->phone ?></span>
        <div class="card mt-3">
            <div class="card-body p-4">
                <?php if ($model->admins->first_acess): ?>
                    <?= \yii\helpers\Html::a('Gerar link de primeiro acesso', ['', 'id' => $model->id, 'access' => 1], [
                            'class' => 'btn mb-3 btn-primary'
                    ]) ?>
                <?php endif ?>
                <?php if ($link): ?>
                    <p class="link">Usuário cadastrado: <span id="link"><?= $javascriptLink ?></span></p>
                    <button id="copy" class="btn btn-secondary">Copiar</button>
                <?php endif ?>
                <h2>Logs de atividade</h2>
                <table class="table table-hover table-bordered rounded-3">
                    <thead>
                    <tr>
                        <th scope="col">Timestamp</th>
                        <th scope="col">Tipo de ação</th>
                        <th scope="col">Descrição da ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>Sun, 04 May 2025 20:26:00 GMT</th>
                        <td><span class="badge text-bg-success">CADASTRO</span></td>
                        <td>Adicionou usuário X</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
    copy.addEventListener('click', async (ev) => {
        await navigator.clipboard.writeText('<?= $javascriptLink?>');
    })
</script>
