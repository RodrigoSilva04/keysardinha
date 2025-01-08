<?php


namespace backend\tests\Functional;

use backend\tests\FunctionalTester;
use Yii;

class LoginBackofficeCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function loginComSucesso(FunctionalTester $I)
    {
        // Acesse a página de login
        $I->amOnRoute('/site/login');

        // Preencha os campos de login com o nome de usuário e senha
        $I->fillField('#loginform-username', 'Utilizadortestefuncional');
        $I->fillField('#loginform-password', 'testefuncional');

        // Clique no botão de login
        $I->click('login-button');

        // Verifique se o link de logout está presente, indicando que o login foi bem-sucedido
        $I->seeElement('#logout-link');  // Verifique se o link de logout está visível

        // Clique no link de logout (opcional, se necessário para limpar a sessão para o próximo teste)
        $I->click('#logout-link');

        // Verifique a URL após o login (se necessário)
        // $I->seeInCurrentUrl('home');  // Substitua 'home' pela URL correta após o login

        // Verifique se o texto esperado de boas-vindas ou nome do usuário está presente
        $I->see('UtilizadorTesteFuncional(admin)');  // Substitua com o texto correto que aparece após o login
    }


    public function loginSemAcesso(FunctionalTester $I)
    {
        $I->amOnRoute('/site/login');

        $I->fillField('#loginform-username', 'testeFuncionalSemAcesso');
        $I->fillField('#loginform-password', 'testefuncional');

        $I->click('login-button');

        $I->see('Utilizador não autorizado a acessar o backoffice.');
    }

    public function loginSemPreencherCampos(FunctionalTester $I)
    {
        $I->amOnRoute('/site/login');

        $I->click('login-button');

        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
    }

    public function logoutComSucesso(FunctionalTester $I)
    {
        $I->amOnRoute('/site/login');

        $I->fillField('#loginform-username', 'Utilizadortestefuncional');
        $I->fillField('#loginform-password', 'testefuncional');

        $I->click('login-button');

        $I->see('UtilizadorTesteFuncional(admin)');
        // Verifique se o link de logout está presente
        $I->seeElement('#logout-link');  // Verifique se o link de logout com o id está presente
        $I->sendAjaxPostRequest('/backend/web/site/logout', [
            '_csrf' => Yii::$app->request->getCsrfToken(),
        ]);
        $I->amOnRoute('/site/login');
        $I->see('Login');
    }
}
