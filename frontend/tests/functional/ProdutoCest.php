<?php


namespace frontend\tests\Functional;

use frontend\tests\FunctionalTester;

class ProdutoCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function testeCompraProdutoSemStock(FunctionalTester $I)
    {
        // 1. Acesse a página de produtos
        $I->amOnRoute('produto/index');

        // 2. Verifique se a página de produtos foi carregada corretamente
        $I->see('Produtos');  // Ajuste de acordo com o título ou elemento da página

        // 3. Selecione o produto (ajuste para o nome ou ID correto do produto)
        $I->seeElement('#add-to-cart-Produto-2');
        $I->click('#add-to-cart-Produto-2');  // Clique no link do produto

        // 4. Verifique a página do produto
        $I->see('✖ Indisponível');  // Ajuste conforme o título da página de produto

        $I->click('Checkout');

        $I->see('O produto Counter-Strike 2 não tem stock suficiente. Remova o produto do carrinho.');

    }

    public function testeCompraProdutoComStock(FunctionalTester $I)
    {
        // 1. Acesse a página de produtos
        $I->amOnRoute('produto/index');

        // 2. Verifique se a página de produtos foi carregada corretamente
        $I->see('Produtos');  // Ajuste de acordo com o título ou elemento da página

        // 3. Selecione o produto (ajuste para o nome ou ID correto do produto)
        $I->seeElement('#add-to-cart-Produto-3');
        $I->click('#add-to-cart-Produto-3');  // Clique no link do produto

        $I->see('✔ Em Stock');

        $I->click('Checkout');

        $I->amOnRoute('carrinho/checkout');

        $I->see('Finalizar Compra');

        $I->click('Finalizar Compra');

        // Agora, aguarde o redirecionamento para a página de fatura
        $I->amOnRoute('fatura/view', ['id' => '24']); // Aqui tentamos acessar a página fatura.view, mas sem o ID

        $I->see('PUBG: BATTLEGROUNDS'); // Verifica se o conteúdo da chave de ativação está visível na página (ajuste o texto conforme necessário)

        $I->see('Back to shop');
    }

}
