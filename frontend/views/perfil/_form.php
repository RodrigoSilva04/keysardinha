<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->params['breadcrumbs'][] = ['label' => 'Perfil', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->id, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->registerCssFile('@web/css/perfil.css');
?>

<?php $form = ActiveForm::begin(); ?>

    <div class="container emp-profile">
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
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="profile-work">
                    <!-- Work content goes here -->
                </div>
            </div>
            <div class="col-md-8">
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <label>User</label>
                            </div>
                            <div class="col-md-6">
                                <p><?= Html::encode($user->username) ?></p>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <label>Nome</label>
                            </div>
                            <div class="col-md-4">
                                <p><?= $form->field($perfil, 'nome')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false) ?></p>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <label>Email</label>
                            </div>
                            <div class="col-md-4">
                                <p><?= $form->field($user, 'email')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false) ?></p>
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
                    <!-- Botão para submeter o formulário -->
                    <div class="form-group">
                        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php ActiveForm::end(); ?>