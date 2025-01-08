<?php


namespace frontend\tests\Acceptance;

use common\models\Fatura;
use frontend\tests\AcceptanceTester;
use Yii;

class ProdutoCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/produto/index');

        $I->see('Produtos');

        $I->click('Sign In');

        $I->wait('3');

        $I->click('Login');

        $I->wait(3);

        $I->fillField('#loginform-username', 'Utilizadortestefuncional');
        $I->fillField('#loginform-password', 'testefuncional');

        $I->click('login-button');

        $I->wait(2);

        $I->amOnPage('produto/index');

        $I->seeElement('a', ['href' => '/frontend/web/site/logout']); // Verify the logout link exists
    }

    public function testeCompraProdutoComStock(AcceptanceTester $I){
        // 1. Acesse a página de produtos
        $I->amOnPage('produto/index');
        $I->wait(3);
        // 2. Verifique se a página de produtos foi carregada corretamente
        $I->see('Produtos');  // Ajuste de acordo com o título ou elemento da página

        // 3. Selecione o produto (ajuste para o nome ou ID correto do produto)
        $I->seeElement('#add-to-cart-Produto-3');
        $I->click('#add-to-cart-Produto-3');  // Clique no link do produto
        $I->wait(1);
        $I->see('✔ Em Stock');

        $I->click('Checkout');

        $I->amOnPage('carrinho/checkout');
        $I->wait(1);

        $I->click('#current-payment');

        $I->click('li[data-method="1"]'); //

        $I->wait(1);

        $I->fillField('#paypal-email', 'email@teste.com');

        $I->see('Finalizar Compra');
        $I->wait(1);
        $I->click('Finalizar Compra');
        $I->wait(1);

        $I->see('PUBG: BATTLEGROUNDS'); // Verifica se o conteúdo da chave de ativação está visível na página (ajuste o texto conforme necessário)

        $I->see('Back to shop');
    }
}
