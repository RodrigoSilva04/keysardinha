    <?php

/** @var yii\web\View $this */

    use yii\helpers\Html;

    $this->title = 'Keysardinha - Sua Loja de Chaves de Jogos';
$this->registerCssFile('@web/css/index.css');
$this->registerJsFile('@web/assetslayout/js/sectionscatalogo.js');
?>
    <div class="main-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="caption header-text">
                        <h6>Bem vindo ao KeySardinha</h6>
                        <h2>O MELHOR WEBSITE PARA <C></C>COMPRAR JOGOS!</h2>
                        <p>O melhor site para comprar jogos do mercado, estamos sempre focados 100% em si e nos seus futuros jogos!</p>
                        <div class="search-input">
                            <form id="search" action="<?= \yii\helpers\Url::to(['site/search']) ?>" method="get">
                                <input type="text" placeholder="Type Something" id='searchText' name="searchKeyword" onkeypress="handle" />
                                <button role="button">Search Now</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-2">
                    <a href="<?= \yii\helpers\Url::to(['produto/view', 'id' => $gta->id]) ?>" class="right-image-link">

                    <div class="right-image">
                            <img src="../imagensjogos/gtav.jpg" alt="GTA V">
                            <span class="price"><?=$gta->preco?>€</span>
                            <span class="offer"><?= $gta->desconto ? round($gta->desconto->percentagem) : 'Sem desconto' ?>%</span>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <a href="#tendencias">
                        <div class="item">
                            <div class="image">
                                <img src="../assetslayout/images/trending.png" alt="" style="max-width: 44px;">
                            </div>
                            <h4>Tendências</h4>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="#mais-jogados">
                        <div class="item">
                            <div class="image">
                                <img src="../assetslayout/images/topgames.png" alt="" style="max-width: 44px;">
                            </div>
                            <h4>Mais jogados</h4>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="#top-categorias">
                        <div class="item">
                            <div class="image">
                                <img src="../assetslayout/images/topcategorias.png" alt="" style="max-width: 44px;">
                            </div>
                            <h4>Top categorias</h4>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <a href="#newsletter">
                        <div class="item">
                            <div class="image">
                                <img src="../assetslayout/images/newsletter.png" alt="" style="max-width: 44px;">
                            </div>
                            <h4>Newsletter</h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="section trending" id="tendencias">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h6>Tendencias</h6>
                        <h2>Jogos nas tendencias</h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="main-button">
                        <a href="<?= \yii\helpers\Url::to(['produto/index']) ?>">Ver todos</a>
                    </div>
                </div>
                <?php foreach ($produtostendencias as $produto): ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="item">
                            <div class="thumb">
                                <a href="<?= \yii\helpers\Url::to(['produto/view', 'id' => $produto->id]) ?>">
                                    <?= // Se a imagem estiver null, mostra uma imagem padrão
                                    $produto->imagem == null ? Html::img('@web/imagensjogos/imagemdefault.jpg', ['alt' => 'Imagem do produto']) :
                                        Html::img('@web/imagensjogos/' . $produto->imagem, ['alt' => 'Imagem do produto']) ?>
                                </a>
                                <span class="price"><?= $produto->preco ?>€</span>
                            </div>
                            <div class="down-content">
                                <span class="category"><?= $produto->categoria->nome ?></span> <!-- A categoria pode ser um campo do modelo -->
                                <h4><?= $produto->nome ?></h4>
                                <a href="<?= \yii\helpers\Url::to(['carrinho/add-to-cart', 'IdProduto' => $produto->id]) ?>">
                                    <i class="fa fa-shopping-bag"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="section most-played" id="mais-jogados">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h6>TOP JOGOS</h6>
                        <h2>Mais jogados</h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="main-button">
                        <a href="shop.html">Ver todos</a>
                    </div>
                </div>

                <!-- Exibe os jogos mais jogados dinamicamente -->
                <?php if (!empty($jogosmaisjogados)): ?>
                    <?php foreach ($jogosmaisjogados as $jogo): ?>
                        <div class="col-lg-2 col-md-6 col-sm-6">
                            <div class="item">
                                <div class="thumb">
                                    <a href="<?= \yii\helpers\Url::to(['produto/view', 'id' => $jogo->id]) ?>">
                                        <?= // Se a imagem estiver null, mostra uma imagem padrão
                                        $jogo->imagem == null ? Html::img('@web/imagensjogos/imagemdefault.jpg', ['alt' => 'Imagem do produto']) :
                                            Html::img('@web/imagensjogos/' . $jogo->imagem, ['alt' => 'Imagem do produto']) ?>
                                        <span class="price"><?= $jogo->preco ?>€</span>
                                    </a>
                                </div>
                                <div class="down-content">
                                    <!-- Exibe a categoria se disponível -->
                                    <span class="category"><?= $jogo->categoria->nome ?? 'Categoria desconhecida' ?></span>
                                    <h4><?= $jogo->nome ?></h4> <!-- Exibe o nome do jogo -->
                                    <a href="<?= \yii\helpers\Url::to(['produto/view', 'id' => $jogo->id]) ?>">Explorar</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-lg-12">
                        <p>Não foi possível carregar os jogos mais jogados.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="section categories" id="top-categorias">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-heading">
                        <h6>Categorias</h6>
                        <h2>Top Categorias</h2>
                    </div>
                </div>


                <?php foreach ($top3categorias as $categoria): ?>
                    <div class="col-lg-4 col-sm-6 col-xs-12"> <!-- Create a new column for each category -->
                        <div class="item">
                            <h4><?= $categoria->nome ?></h4>
                            <div class="thumb">
                                <a href="<?= \yii\helpers\Url::to(['categoria/view', 'id' => $categoria->id]) ?>"> <!-- Link to category view page -->
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>



    <div class="section cta" id="newsletter">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="shop">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-heading">
                                    <h6>A nossa loja</h6>
                                    <h2>Compra aqui e obtém os melhores <em>Preços</em> para ti!</h2>
                                </div>
                                <p>Explora o nosso catálogo de jogos</p>
                                <div class="main-button">
                                    <a href="<?= \yii\helpers\Url::to(['produto/index']) ?>">Compre agora</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-2 align-self-end">
                    <div class="subscribe">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-heading">
                                    <h6>NEWSLETTER</h6>
                                    <h2>Obtem as nossas novidades <em>subscrevendo</em> a Newsletter!</h2>
                                </div>
                                <div class="search-input">
                                    <form id="subscribe" action="#">
                                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Your email...">
                                        <button type="submit">Receber emails</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>