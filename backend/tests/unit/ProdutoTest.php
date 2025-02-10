<?php

namespace backend\tests\unit;

use common\models\Produto;
use Codeception\Test\Unit;

class ProdutoTest extends \Codeception\Test\Unit
{
    /**
     * @var \tests\UnitTester
     */
    protected $tester;

    // Teste do nome do produto
    public function testNome()
    {
        $produto = new Produto();
        $produto->nome = 'Produto 1';
        $this->assertTrue($produto->validate(['nome']));
    }

    // Teste do nome do produto como null (deve ser válido)
    public function testProdutoIncompleto()
    {
        $produto = new Produto();
        $produto->nome = null;  // Nome obrigatório
        $produto->preco = 20.00;

        // Produto não deve ser válido sem nome
        $this->assertFalse($produto->validate());

        // Agora define o nome
        $produto->nome = 'Produto Incompleto';

        // O produto deve ser válido com todos os campos preenchidos corretamente
        $this->assertTrue($produto->validate());
    }

    // Teste do nome do produto como string vazia (deve ser inválido)
    public function testNomeVazio()
    {
        $produto = new Produto();
        $produto->nome = '';
        $this->assertFalse($produto->validate(['nome']));
    }

    // Teste de um produto completo, verificando que todos os campos são válidos
    public function testProdutoCompleto()
    {
        $produto = new Produto();
        $produto->nome = 'Produto 1';
        $produto->descricao = 'Descrição do produto 1';
        $produto->preco = 10.00;
        $produto->imagem = 'boa';
        $produto->datalancamento = '2021-01-01';
        $produto->stockdisponivel = 10;
        $produto->categoria_id = 1;
        $produto->desconto_id = 1;
        $produto->iva_id = 1;
        $this->assertTrue($produto->validate());
    }



    // Teste para validar que o preço não pode ser zero (se a regra for maior que zero)
    public function testPrecoZero()
    {
        $produto = new Produto();
        $produto->preco = 0.00;
        $this->assertTrue($produto->validate(['preco']));
    }

    // Teste para garantir que o preço seja válido (maior que zero)
    public function testPrecoValido()
    {
        $produto = new Produto();
        $produto->preco = 10.00;
        $this->assertTrue($produto->validate(['preco']));
    }

    // Teste para verificar um produto com campo de imagem vazio
    public function testImagemVazia()
    {
        $produto = new Produto();
        $produto->imagem = ''; // Deve ser válido, a menos que haja uma validação explícita
        $this->assertTrue($produto->validate(['imagem']));
    }

    public function testProdutoSave()
    {
        $produto = new Produto();
        $produto->nome = 'Produto Teste';
        $produto->descricao = 'Descrição do Produto Teste';
        $produto->preco = 50.00;
        $produto->imagem = 'imagem_produto.png';
        $produto->datalancamento = '2023-05-10';
        $produto->stockdisponivel = 100;
        $produto->categoria_id = 1;
        $produto->desconto_id = 1;
        $produto->iva_id = 1;

        // Guarda o produto na base de dados
        $this->assertTrue($produto->save());

        // Verifica se o produto foi realmente guardado
        $produtoSave = Produto::findOne(['nome' => 'Produto Teste']);
        $this->assertNotNull($produtoSave);
        $this->assertEquals('Produto Teste', $produtoSave->nome);
    }

    public function testProdutoUpdate()
    {
        $produto = Produto::findOne(2); // Supondo que já exista um produto com ID 1
        $produto->preco = 60.00;

        $this->assertTrue($produto->save());

        // Verifica se o preço foi atualizado corretamente
        $produtoUpdate = Produto::findOne(2);
        $this->assertEquals(60.00, $produtoUpdate->preco);
    }
    public function testProdutoDelete()
    {
        $produto = Produto::findOne(2); // Supondo que o produto com ID 1 exista
        $this->assertTrue($produto->delete() > 0);

        // Verifica se o produto foi realmente deleted
        $produtoDeleted = Produto::findOne(2);
        $this->assertNull($produtoDeleted);
    }
    public function testDataLancamentoValida()
    {
        $produto = new Produto();
        $produto->datalancamento = '2025-01-01';
        $this->assertTrue($produto->validate(['datalancamento']));  // Teste para data válida
    }

    public function testDataLancamentoInvalida()
    {
        $produto = new Produto();
        $produto->datalancamento = 'invalid-date';
        $this->assertFalse($produto->validate(['datalancamento']));  // Teste para data inválida
    }


}
