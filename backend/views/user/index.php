<?php

use common\models\User;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email:email',
            [
                'attribute' => 'name',
                'label' => 'Nome do Perfil',
                'value' => function($model) {
                    $perfil = $model->getPerfil();
                    return $perfil ? $perfil->nome : 'Não atribuído nome';
                },
            ],
            [
                'attribute' => 'Dataregisto',
                'label' => 'Data de registo',
                'value' => function($model) {
                    $perfil = $model->getPerfil();
                    return $perfil ? $perfil->dataregisto : 'Não atribuída data de registo';
                },
            ],
            [
                'attribute' => 'pontosacumulados',
                'label' => 'Pontos Acumulados',
                'value' => function($model) {
                    $perfil = $model->getPerfil();
                    return $perfil ? $perfil->pontosacumulados : 'Não atribuídos pontos acumulados';
                },
            ],
            [
                'attribute' => 'carrinho_id',
                'label' => 'Carrinho Associado',
                'value' => function($model) {
                    $perfil = $model->getPerfil();
                    return $perfil ? $perfil->carrinho_id : 'Não tem carrinho atribuído';
                },
            ],
            'role',
            'status',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'template' => '{view} {update} {delete} {block}',  // Adiciona o botão de bloquear
                'buttons' => [
                    'block' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="fa fa-ban"></i>', // Ícone de bloqueio
                            ['bloquear', 'id' => $model->id], // URL para a ação de bloquear
                            [
                                'title' => Yii::t('app', 'Block'), // Tooltip do botão
                                'data-confirm' => Yii::t('app', 'Are you sure you want to block this user?'), // Mensagem de confirmação
                                'data-method' => 'post', // Método POST para realizar a ação
                                'class' => 'btn btn-warning btn-xs', // Estilo do botão
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

</div>
