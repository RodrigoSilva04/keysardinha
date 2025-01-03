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

        $I->amOnRoute('/site/login');

        $I->fillField('#loginform-username', 'Utilizadortestefuncional');
        $I->fillField('#loginform-password', 'testefuncional');

        $I->click('login-button');

        $I->see('UtilizadorTesteFuncional(admin)');
        // Verifique se o link de logout está presente
        $I->seeElement('#logout-link');  // Verifique se o link de logout com o id está presente
        $I->click('#logout-link');  // Clique no link de logout pelo id

    }

    public function loginSemAcesso(FunctionalTester $I)
    {
        $I->amOnRoute('/site/login');

        $I->fillField('#loginform-username', 'roberto1');
        $I->fillField('#loginform-password', 'roberto1');

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
