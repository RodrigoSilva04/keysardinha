<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use Yii;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!-- O botão Update, que agora também será usado para atualizar a role -->
        <?= Html::a('Update', ['update', 'id' => $model->id], [
            'class' => 'btn btn-primary',
            'data' => [
                'method' => 'post',
                'params' => [
                    'role' => Yii::$app->request->post('role'), // A role selecionada será enviada com o formulário
                ],
            ],
        ]) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            'status',
            'created_at',
            'updated_at',
            'role',
        ],
    ]) ?>

</div>
