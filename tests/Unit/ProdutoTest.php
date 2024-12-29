<?php

namespace tests\unit;

use common\models\Produto;
use Codeception\Test\Unit;
use common\fixtures\ProdutoFixture;

class ProdutoTest extends \Codeception\Test\Unit
{
    /**
     * @var \tests\UnitTester
     */
    protected $tester;

    public function _fixtures()
    {
        return [
            'produto' => [
                'class' => ProdutoFixture::class,
                'dataFile' => codecept_data_dir() . 'produto.php',
            ]
        ];
    }

    public function testSomeFeature()
    {
        $produto = new Produto();
        $produto->nome = 'Produto 1';
        $this->assertTrue($produto->validate(['nome']));
    }
}


