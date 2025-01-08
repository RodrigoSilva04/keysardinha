<?php


namespace backend\tests\Unit;

use backend\tests\UnitTester;
use common\models\Cupao;

class CupaoTest extends \Codeception\Test\Unit
{
    /**
     * @var \tests\UnitTester
     */

    protected $tester;

    protected function _before()
    {

    }

    // tests
    public function testCriarCupao()
    {
        $cupao = new Cupao();
        $cupao->datavalidade = '2021-12-31 23:59:59';
        $cupao->valor = 10;
        $cupao->ativo = 1;
        $cupao->codigo = 'CUPAO10';
        $this->assertTrue($cupao->validate());
    }
    public function testCriarCupaoIncompleto()
    {
        $cupao = new Cupao();
        $cupao->ativo = 1;
        $cupao->valor = null;

        $this->assertFalse($cupao->validate());

        $cupao->valor = 10;

        $this->assertTrue($cupao->validate());
    }
     public function testValorVazio()
    {
        $cupao = new Cupao();
        $cupao->valor = null;
        $this->assertFalse($cupao->validate(['valor']));
    }
}
