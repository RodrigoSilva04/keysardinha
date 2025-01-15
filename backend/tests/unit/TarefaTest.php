<?php


namespace backend\tests\Unit;

use backend\tests\UnitTester;
use common\models\Tarefa;

class TarefaTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    // Testa falta de boolean
    public function testFaltaFeito()
    {
        $model = new Tarefa();

        // Verifica se a validação falha para o campo 'feito'
        $this->assertFalse($model->validate(['feito']));
        $this->assertArrayHasKey('feito', $model->errors);
    }

    // Testa um feito válido
    public function testFeitoValido()
    {
        $model = new Tarefa();
        $model-> feito = '1';

        // Verifica se a validação passa
        $this->assertTrue($model->validate(['feito']));
    }

    //Testa sem descrição
    public function testFaltaDescricao()
    {
        $model = new Tarefa();

        // Verifica se a validação falha para o campo 'feito'
        $this->assertFalse($model->validate(['descricao']));
        $this->assertArrayHasKey('descricao', $model->errors);
    }

    // Testa uma descrição válida
    public function testDescricaoValida()
    {
        $model = new Tarefa();
        $model->descricao = 'ir dar banho à cadela';

        // Verifica se a validação passa
        $this->assertTrue($model->validate(['descricao']));
    }

    // Testa descrição com tipo inválido
    public function testDescricaoTipoInvalido()
    {
        $model = new Tarefa();
        $model->descricao = 12345; // Tipo inválido

        // Verifica se a validação falha
        $this->assertFalse($model->validate(['descricao']));
        $this->assertArrayHasKey('descricao', $model->errors);
    }

    // Testa descrição com comprimento inválido
    public function testDescricaoComprimentoInvalido()
    {
        $model = new Tarefa();
        $model->descricao = str_repeat('a', 256); // Excede 255 caracteres

        // Verifica se a validação falha
        $this->assertFalse($model->validate(['descricao']));
        $this->assertArrayHasKey('descricao', $model->errors);
    }
}
