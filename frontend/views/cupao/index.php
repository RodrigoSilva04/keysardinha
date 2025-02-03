<?php

use common\models\Cupao;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Cupões';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cupao-index">
    <div class="container">
        <h1 class="text-center">Você tem <?= $pontos?> pontos</h1>
        <div class="row">
            <!-- Cupão de 10€ -->
            <div class="col-md-4">
                <div class="card cupao-card">
                    <img src="../../web/10€.jpg" class="card-img-top" alt="Cupão 10€">
                    <div class="card-body text-center">
                        <h5 class="card-title">Cupão de 10€</h5>
                        <p class="card-text"><strong>100 Pontos</strong></p>
                        <form action="<?= \yii\helpers\Url::to(['cupao/trocar']) ?>" method="post">
                            <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->csrfToken ?>">
                            <input type="hidden" name="valor" value="10">
                            <input type="hidden" name="pontosnecessarios" value="100">
                            <button type="submit" class="btn btn-primary">Resgatar</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Cupão de 50€ -->
            <div class="col-md-4">
                <div class="card cupao-card">
                    <img src="../../web/50€.jpg" class="card-img-top" alt="Cupão 50€">
                    <div class="card-body text-center">
                        <h5 class="card-title">Cupão de 50€</h5>
                        <p class="card-text"><strong>400 Pontos</strong></p>
                        <form action="<?= \yii\helpers\Url::to(['cupao/trocar']) ?>" method="post">
                            <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->csrfToken ?>">
                            <input type="hidden" name="valor" value="50">
                            <input type="hidden" name="pontosnecessarios" value="400">
                            <button type="submit" class="btn btn-primary">Resgatar</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Cupão de 20€ -->
            <div class="col-md-4">
                <div class="card cupao-card">
                    <img src="../../web/20€.jpg" class="card-img-top" alt="Cupão 20€">
                    <div class="card-body text-center">
                        <h5 class="card-title">Cupão de 20€</h5>
                        <p class="card-text"><strong>190 Pontos</strong></p>
                        <form action="<?= \yii\helpers\Url::to(['cupao/trocar']) ?>" method="post">
                            <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->csrfToken ?>">
                            <input type="hidden" name="valor" value="20">
                            <input type="hidden" name="pontosnecessarios" value="190">
                            <button type="submit" class="btn btn-primary">Resgatar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

