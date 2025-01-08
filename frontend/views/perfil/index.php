<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Utilizadorperfil $perfil */
/** @var common\models\User $user */

$this->title = 'Meu Perfil';
$this->registerCssFile('@web/css/perfil.css');
$this->registerJsFile('@web/js/perfil.js');
?>

<div class="container emp-profile">
    <form method="post">
        <div class="row">
            <div class="col-md-4">
                <div class="profile-img">
                    <?= Html::a(
                        Html::img('@web/logokeysardinha.webp', ['alt' => 'Logo', 'style' => 'width: 158px;']),
                        Yii::$app->homeUrl,
                        ['class' => 'logo']
                    ) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="profile-head">
                    <h5>
                        <?= Html::encode($user->username) ?>
                    </h5>
                    <p class="proile-rating">Pontos Fidelidade : <span><?= Html::encode($perfil->pontosacumulados) ?></span></p>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <?= Html::a('Editar Perfil', ['update'], ['class' => 'profile-edit-btn']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="profile-work">
                    <p>Compras</p>
                    <!-- Botão para trocar o conteúdo -->
                    <div class="mt-3">
                        <button id="view-invoices-btn" class="btn btn-primary" type="button">Ver Faturas</button>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="tab-content profile-tab" id="myTabContent">
                    <div id="profile-details">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>User</label>
                                </div>
                                <div class="col-md-6">
                                    <p><?= Html::encode($user->username) ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Nome</label>
                                </div>
                                <div class="col-md-6">
                                    <p><?= Html::encode($perfil->nome ?? 'Nome não definido') ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-6">
                                    <p><?= Html::encode($user->email) ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Data de Registo</label>
                                </div>
                                <div class="col-md-6">
                                    <p><?= Html::encode($perfil->dataregisto) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order-table-container" style="max-height: 400px; overflow-y: auto;">
                    <!-- Seção das faturas (oculta inicialmente) -->
                    <div id="invoice-details" style="display: none;">
                        <div class="tab-pane fade show active" id="invoices" role="tabpanel" aria-labelledby="invoices-tab">
                            <?php if (!empty($faturas)): ?>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Valor</th>
                                        <th>Estado</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($faturas as $fatura): ?>
                                        <tr>
                                            <td><?= Html::encode($fatura->datafatura) ?></td>
                                            <td>€<?= number_format($fatura->valor_total) ?></td>
                                            <td><?= Html::encode($fatura->estado) ?></td>
                                            <td>
                                                <?= Html::a(
                                                    'Detalhes',
                                                    ['fatura/view', 'id' => $fatura->id],
                                                    ['class' => 'btn btn-sm btn-primary']
                                                ) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p>Nenhuma fatura encontrada.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Botão para voltar aos detalhes do perfil -->
                        <button id="back-to-profile-btn" class="btn btn-secondary mt-3" type="button">Voltar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
