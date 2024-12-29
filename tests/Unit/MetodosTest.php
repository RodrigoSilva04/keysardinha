<?php


namespace Tests\Unit;

use common\models\Metodopagamento;
use Tests\Support\UnitTester;

class MetodosTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $metodo = new Metodopagamento();
        $metodo->nomemetodopagamento = 'MBWay';
        $this->assertTrue($metodo->validate(['nomemetodopagamento']));
    }
}
