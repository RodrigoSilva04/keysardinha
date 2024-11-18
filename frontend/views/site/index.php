    <?php

/** @var yii\web\View $this */

$this->title = 'Keysardinha - Sua Loja de Chaves de Jogos';
$this->registerCssFile('@web/css/index.css');
?>
    <div class="container-fluid bg-light-blue py-3">
        <div class="box-container">
            <p class="small-text">A chave para diversão está aqui! Desbloqueia os teus jogos favoritos com a KeySardinha!!</p>
        </div>
    </div>
<div class="site-index">
    <!-- Carousel Section -->
    <div class="main-content">
        <div class="p-3 mb-4 bg-transparent rounded-3">
            <div class="container-fluid py-5 text-center">
                <h1 class="display-5 fw-bold" style="font-family: 'Arial', sans-serif;">Top Vendas</h1>
                <p class="fs-5 fw-bold" style="font-family: 'Arial', sans-serif;">Venha ver os jogos mais comprados pelos gamers!!</p>
            </div>
        </div>
        <div class="carousel-container">
            <?php if (!empty($produtos)): ?>
                <?php
                // Limitar a exibição a no máximo 3 produtos
                $produtos = array_slice($produtos, 0, 3);
                ?>
                <?php foreach ($produtos as $index => $produto): ?>
                    <input type="radio" name="slider-top-vendas" id="top-vendas-item-<?= $index + 1 ?>" <?= $index === 0 ? 'checked' : '' ?>>
                <?php endforeach; ?>

                <div class="carousel-cards">
                    <?php foreach ($produtos as $index => $produto): ?>
                        <label class="carousel-card" for="top-vendas-item-<?= $index + 1 ?>" id="top-vendas-card-<?= $index + 1 ?>">
                            <img src="<?= Yii::getAlias('@web') ?>/imagensjogos/<?= $produto->imagem ?>" alt="<?= $produto->nome ?>" class="card-image">
                            <div class="card-info">
                                <h5 class="card-title"><?= $produto->nome ?></h5>
                                <p class="card-description"><?= $produto->descricao ?></p>
                                <a href="/frontend/web/produto/view?id=<?= $produto->id ?>" class="btn btn-primary">Ver Detalhes</a>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No products available.</p>
            <?php endif; ?>
        </div>

    </div>

    <div class="main-content" id="content-promoçoes">
        <div class="p-3 mb-4 bg-transparent rounded-3">
            <div class="container-fluid py-5 text-center">
                <h1 class="display-5 fw-bold" style="font-family: 'Arial', sans-serif;">Top Promoções</h1>
                <p class="fs-5 fw-bold" style="font-family: 'Arial', sans-serif;">Venha ver as nossas promoções</p>
            </div>
        </div>
        <div class="carousel-container">
            <?php if (!empty($produtos)): ?>
                <?php
                // Limitar a exibição a no máximo 3 produtos
                $produtos = array_slice($produtos, 0, 3);
                ?>
                <?php foreach ($produtos as $index => $produto): ?>
                    <input type="radio" name="slider-top-promocoes" id="top-promocoes-item-<?= $index + 1 ?>" <?= $index === 0 ? 'checked' : '' ?>>
                <?php endforeach; ?>

                <div class="carousel-cards">
                    <?php foreach ($produtos as $index => $produto): ?>
                        <label class="carousel-card" for="top-promocoes-item-<?= $index + 1 ?>" id="top-promocoes-card-<?= $index + 1 ?>">
                            <img src="<?= Yii::getAlias('@web') ?>/imagensjogos/<?= $produto->imagem ?>" alt="<?= $produto->nome ?>" class="card-image">
                            <div class="card-info">
                                <h5 class="card-title"><?= $produto->nome ?></h5>
                                <p class="card-description"><?= $produto->descricao ?></p>
                                <a href="/jogo/<?= $produto->id ?>" class="btn btn-primary">Ver Detalhes</a>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No products available.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="main-content">
        <div class="p-3 mb-4 bg-transparent rounded-3">
            <div class="container-fluid py-5 text-center">
                <h1 class="display-5 fw-bold" style="font-family: 'Arial', sans-serif;">A nossas recomendações</h1>
                <p class="fs-5 fw-bold" style="font-family: 'Arial', sans-serif;">Todos os jogos que recomendamos comprar</p>
            </div>
        </div>
        <div class="carousel-container">
            <?php if (!empty($produtos)): ?>
                <?php
                // Limitar a exibição a no máximo 3 produtos
                $produtos = array_slice($produtos, 0, 3);
                ?>
                <?php foreach ($produtos as $index => $produto): ?>
                    <input type="radio" name="slider" id="top-recomendacoes-item-<?= $index + 1 ?>" <?= $index === 0 ? 'checked' : '' ?>>
                <?php endforeach; ?>

                <div class="carousel-cards">
                    <?php foreach ($produtos as $index => $produto): ?>
                        <label class="carousel-card" for="top-recomendacoes-item-<?= $index + 1 ?>" id="top-recomendacoes-card-<?= $index + 1 ?>">
                            <img src="<?= Yii::getAlias('@web') ?>/imagensjogos/<?= $produto->imagem ?>" alt="<?= $produto->nome ?>" class="card-image">
                            <div class="card-info">
                                <h5 class="card-title"><?= $produto->nome ?></h5>
                                <p class="card-description"><?= $produto->descricao ?></p>
                                <a href="/produto/<?= $produto->id ?>" class="btn btn-primary">Ver Detalhes</a>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No products available.</p>
            <?php endif; ?>
        </div>

    </div>

</div>
