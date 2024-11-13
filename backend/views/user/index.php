<?php

use common\models\User;
use common\models\Utilizadorperfil;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email:email',
            [
                'attribute' => 'name', // Exemplo de nome fictício
                'label' => 'Nome do Perfil',
                'value' => function($model) {
                    // Chama o método para buscar o perfil
                    $perfil = $model->getPerfil();
                    return $perfil ? $perfil->nome : 'Não atribuio nome';
                },
            ],
            [
                'attribute' => 'Dataregisto', // Exemplo de nome fictício
                'label' => 'Data de registo',
                'value' => function($model) {
                    // Chama o método para buscar o perfil
                    $perfil = $model->getPerfil();
                    return $perfil ? $perfil->dataregisto : 'Não atribuio data de registo';
                },
            ],
            [
                'attribute' => 'pontosacumulados', // Exemplo de nome fictício
                'label' => 'Pontos Acumulados',
                'value' => function($model) {
                    // Chama o método para buscar o perfil
                    $perfil = $model->getPerfil();
                    return $perfil ? $perfil->pontosacumulados : 'Não atribuio pontos acumulados';
                },
            ],
            [
                'attribute' => 'carrinho_id', // Exemplo de nome fictício
                'label' => 'Carrinho Associado',
                'value' => function($model) {
                    // Chama o método para buscar o perfil
                    $perfil = $model->getPerfil();
                    return $perfil ? $perfil->carrinho_id : 'Não tem carrinho atribuido';
                },
            ],
            [
                'attribute' => 'role',
                'label' => 'Role', // Título da coluna
                'value' => function($model) {
                    // Supondo que você tenha configurado RBAC e o `user` tenha uma relação com a role
                    $auth = Yii::$app->authManager;
                    $roles = $auth->getRolesByUser($model->id);
                    return !empty($roles) ? key($roles) : 'Não tem role atribuida'; // Pega o nome da role
                },
            ],
            'status',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
