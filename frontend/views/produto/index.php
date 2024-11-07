<?php
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

use yii\helpers\Html;

$this->title = 'Lista de Produtos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <?php foreach ($dataProvider->getModels() as $model): ?>
            <div class="col-md-4 mb-4">
                <div class="card border-primary" style="background-color: #f8f9fa;">
                    <img src="<?= Html::encode($model->imagem) ?>" class="card-img-top" alt="<?= Html::encode($model->nome) ?>">
                    <div class="card-body">
                        <h5 class="card-title text-primary"><?= Html::encode($model->nome) ?></h5>
                        <p class="card-text"><?= Html::encode($model->descricao) ?></p>
                        <p class="card-text"><strong>Preço:</strong> <?= Html::encode($model->preco) ?>€</p>
                        <?php
                        // Verifica se o produto está nos favoritos (substitua pela lógica real)
                        $isFavorito = false; // Exemplo de estado; você precisará implementar a lógica
                        $favoritoIcon = $isFavorito ? 'fas fa-heart' : 'far fa-heart'; // Ícone cheio ou vazio
                        $favoritoColor = $isFavorito ? 'text-danger' : 'text-primary'; // Cor do ícone
                        ?>
                        <?= Html::a('Ver Detalhes', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class="' . $favoritoIcon . ' ' . $favoritoColor . '"></i>', ['favoritos/add', 'id' => $model->id], ['class' => 'btn btn-link p-0']) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>
