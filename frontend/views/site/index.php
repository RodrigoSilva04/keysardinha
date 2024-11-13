<?php

/** @var yii\web\View $this */

$this->title = 'Keysardinha - Sua Loja de Chaves de Jogos';
?>
<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4">Catálogo de Jogos</h1>
            <p class="fs-5 fw-light">Explore nossa vasta seleção de chaves de jogos e encontre os melhores títulos para você!</p>
        </div>
    </div>

    <div class="body-content">
        <div class="row">
            <?php foreach ($produtos as $produto): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card">
                        <img src="<?= $produto->imagem ?>" class="card-img-top" alt="<?= $produto->nome ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $produto->nome ?></h5>
                            <p class="card-text"><?= $produto->descricao ?></p>
                            <a href="/jogo/<?= $produto->id ?>" class="btn btn-primary">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
