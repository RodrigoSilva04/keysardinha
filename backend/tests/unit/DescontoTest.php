<?php


namespace backend\tests\Unit;

use backend\tests\UnitTester;
use common\models\Desconto;

class DescontoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // tests
    public function testDescontoNegativo()
    {
        $desconto = new Desconto();
        $desconto->percentagem = -10.00; // Exemplo de valor negativo

        // Validação do modelo
        $this->assertFalse($desconto->validate(), 'O modelo deve ser inválido para percentagem negativa');
        $desconto->percentagem =10;
        $this->assertTrue($desconto->validate(), 'O modelo deve ser válido para percentagem negativa');
    }

    // Valida a percentagem de desconto pode ser zero
    public function testDescontoZero()
    {
        $desconto = new Desconto();
        $desconto->percentagem = 0.00; // Valor válido

        $this->assertTrue($desconto->validate(['percentagem']), 'Desconto de zero deve ser válido');
    }

    // Testa atualizar um desconto existente
    public function testDescontoUpdate()
    {
        $desconto = Desconto::findOne(1); // Supondo que exista um desconto com ID 1
        $desconto->percentagem = 50.00;

        $this->assertTrue($desconto->save(), 'Desconto atualizado deve ser guardado com sucesso');

        // Verifica se a percentagem foi atualizada corretamente
        $descontoUpdated = Desconto::findOne(1);
        $this->assertEquals(50.00, $descontoUpdated->percentagem);
    }

    // Teste para excluir um desconto existente
    public function testDescontoDelete()
    {
        $desconto = Desconto::findOne(1); // Supondo que o desconto com ID 1 exista
        $this->assertTrue($desconto->delete() > 0, 'O desconto deve ser deletado com sucesso');

        // Verifica se o desconto foi realmente deletado
        $descontoDeleted = Desconto::findOne(1);
        $this->assertNull($descontoDeleted);
    }

}
