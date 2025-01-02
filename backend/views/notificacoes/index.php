<?php

use yii\helpers\Html;

$this->title = 'Notificações em Tempo Real';
?>
<div class="notificacoes-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Mensagem</th>
            <th>Recebido em</th>
        </tr>
        </thead>
        <tbody id="tabela-notificacoes">
        <!-- As notificações recebidas serão inseridas aqui -->
        </tbody>
    </table>
</div>

<?php
$js = <<<JS
const tabelaNotificacoes = document.getElementById('tabela-notificacoes');
let contador = 1; // Para numerar as notificações

// Conectar ao WebSocket
const socket = new WebSocket('ws://localhost:9001'); // Substitua pelo endereço do broker WebSocket

// Quando uma mensagem é recebida
socket.onmessage = function(event) {
    const data = event.data; // Mensagem recebida do broker
    const timestamp = new Date().toLocaleString(); // Data e hora local

    // Criar uma nova linha para a tabela
    const novaLinha = document.createElement('tr');
    novaLinha.innerHTML = `
        <td>\${contador}</td>
        <td>\${data}</td>
        <td>\${timestamp}</td>
    `;

    // Adicionar a nova linha na tabela
    tabelaNotificacoes.prepend(novaLinha);
    contador++;
};

// Tratar erros
socket.onerror = function(error) {
    console.error('Erro na conexão WebSocket:', error);
};
JS;

$this->registerJs($js);
?>
