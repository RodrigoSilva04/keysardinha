<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Carrinho;
use common\models\Chavedigital;
use common\models\Cupao;
use common\models\Fatura;
use common\models\Linhacarrinho;
use common\models\Linhafatura;
use common\models\Metodopagamento;
use common\models\Produto;
use common\models\User;
use common\models\Utilizadorperfil;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\rest\Controller;

class CarrinhoController extends ActiveController
{
    public $modelClass = 'common\models\Carrinho';
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }
    public function actionFindCarrinho()
{
    $user = Yii::$app->user;

    if (!$user) {
        return Yii::$app->response->setStatusCode(401)->data = [
            'status' => 'error',
            'message' => 'Token inválido ou usuário não autenticado.',
        ];
    }

    // Obter o carrinho do usuário autenticado
    $carrinho = Carrinho::findOne(['utilizadorperfil_id' => $user->id]);

    if (!$carrinho) {
        // Cria um carrinho vazio para o utilizador
        $carrinho = new Carrinho();
        $carrinho->utilizadorperfil_id = $user->id;
        $carrinho->data_criacao = new \yii\db\Expression('NOW()'); 
        if (!$carrinho->save()) {
            Yii::error('Erro ao criar o carrinho para o utilizador ID: ' . $user->id . '. Erros: ' . json_encode($carrinho->errors), __METHOD__);
            return Yii::$app->response->setStatusCode(400)->data = [
                'status' => 'error',
                'message' => 'Erro ao criar o carrinho.',
                'errors' => $carrinho->errors,
            ];
        }
        return Yii::$app->response->setStatusCode(201)->data = [
            'status' => 'success',
            'message' => 'O utilizador não tinha um carrinho, mas foi criado um.',
        ];
    }

    // Buscar as linhas do carrinho associado
    $linhasCarrinho = Linhacarrinho::find()
        ->where(['carrinho_id' => $carrinho->id])
        ->with('produto')  // Assuming you have a relation defined with 'produto'
        ->all();

    // Calcular o total do carrinho
    $total = 0;
    foreach ($linhasCarrinho as $linha) {
        $total += $linha->quantidade * $linha->preco_unitario;
    }

    // Retornar os dados do carrinho
    return Yii::$app->response->setStatusCode(200)->data = [
        'status' => 'success',
        'message' => 'Carrinho recuperado com sucesso para o usuário ID: ' . $user->id,
        'carrinho' => [
            'id' => $carrinho->id,
            'data_criacao' => $carrinho->data_criacao,
            'cupao_id' => $carrinho->cupao_id,
            'utilizadorperfil_id' => $carrinho->utilizadorperfil_id,
            'total' => number_format($total, 2),  // Formatar o total como moeda
        ],
        'linhasCarrinho' => array_map(function ($linha) {
            return [
                'id' => $linha->id,
                'quantidade' => $linha->quantidade,
                'preco_unitario' => $linha->preco_unitario,
                'preco_total' => $linha->quantidade * $linha->preco_unitario,
                'produto_id' => $linha->produto_id,
                'produto' => [
                    'id' => $linha->produto->id,
                    'nome' => $linha->produto->nome,
                    'categoria' => $linha->produto->categoria->nome,
                    'descricao' => $linha->produto->descricao,
                    'preco' => $linha->produto->preco,
                    'stockdisponivel' => $linha->produto->stockdisponivel,
                    'imagem' => Yii::getAlias('@frontend/web/imagensjogos/') . '/' . $linha->produto->imagem,
                    'datalancamento' => $linha->produto->datalancamento,
                    'desconto' => $linha->produto->desconto->percentagem,
                    'iva' => $linha->produto->iva->taxa,
                ],
            ];
        }, $linhasCarrinho),
    ];
}


    public function actionView()
    {
        // Busca o modelo do carrinho com base no ID
        $id = Yii::$app->request->get('id');
        $carrinho = Carrinho::findOne($id);

        if (!$carrinho) {
            Yii::$app->response->statusCode = 404;
            return [
                'status' => 'error',
                'message' => 'Carrinho não encontrado.',
            ];
        }

        // Busca as linhas associadas ao carrinho
        $linhasCarrinho = Linhacarrinho::find()->where(['carrinho_id' => $carrinho->id])->all();

        // Prepara os dados das linhas do carrinho
        $linhas = [];
        foreach ($linhasCarrinho as $linha) {
            $linhas[] = [
                'produto_id' => $linha->produto_id,
                'nome' => $linha->produto->nome, // Assumindo relação com Produto
                'quantidade' => $linha->quantidade,
                'preco_unitario' => $linha->preco_unitario,
                'subtotal' => $linha->quantidade * $linha->preco_unitario,
            ];
        }

        // Retorna os detalhes do carrinho e suas linhas
        Yii::$app->response->statusCode = 200;
        return [
            'status' => 'success',
            'carrinho' => [
                'id' => $carrinho->id,
                'data_criacao' => $carrinho->data_criacao,
                'utilizador_id' => $carrinho->utilizadorperfil_id,
            ],
            'linhas' => $linhas,
        ];
    }


    public function actionUpdate()
    {
        // Obtém o produto ID da requisição POST
        $produtoID = Yii::$app->request->post('produto_id');

        // Encontra o carrinho do utilizador
        $carrinho = Carrinho::findOne(['utilizadorperfil_id' => Yii::$app->user->id]);

        // Verifica se o carrinho foi encontrado
        if (!$carrinho) {
            return Yii::$app->response->setStatusCode(404)->data = [
                'status' => 'error',
                'message' => 'Carrinho não encontrado.',
            ];
        }

        // Verifica se a requisição é POST
        if (Yii::$app->request->isPost) {
            // Carrega os dados da requisição no modelo
            if ($carrinho->load(Yii::$app->request->post())) {
                // Verifica se o carrinho foi salvo corretamente
                if ($carrinho->save()) {
                    // Se a atualização for bem-sucedida, retorna um status de sucesso
                    return Yii::$app->response->setStatusCode(200)->data = [
                        'status' => 'success',
                        'message' => 'Carrinho atualizado com sucesso.',
                        'data' => $carrinho,
                    ];
                } else {
                    // Se ocorrer um erro ao salvar, retorna os erros em formato JSON
                    Yii::error("Erro ao atualizar o carrinho: " . json_encode($carrinho->errors), __METHOD__);
                    return Yii::$app->response->setStatusCode(400)->data = [
                        'status' => 'error',
                        'message' => 'Erro ao atualizar o carrinho.',
                        'errors' => $carrinho->errors,
                    ];
                }
            }
        }

        // Se não for uma requisição POST, retorna um erro
        return Yii::$app->response->setStatusCode(405)->data = [
            'status' => 'error',
            'message' => 'Método não permitido.',
        ];
    }


    public function actionDelete()
    {
        // Busca o carrinho com o ID fornecido pelo post
        $carrinho = Carrinho::findOne(Yii::$app->request->post('id'));

        // Se o modelo não for encontrado, retornamos uma resposta de erro
        if (!$carrinho) {
            return Yii::$app->response->setStatusCode(404)->data = [
                'status' => 'error',
                'message' => 'Carrinho não encontrado.',
            ];
        }

        // Deleta o modelo
        if ($carrinho->delete()) {
            //Da tb delete nas linhas do carrinho com o id do carrinho
            Linhacarrinho::deleteAll(['carrinho_id' => $carrinho->id]);

            // Retorna uma resposta de sucesso
            return Yii::$app->response->setStatusCode(200)->data = [
                'status' => 'success',
                'message' => 'Carrinho deletado com sucesso.',
            ];
        } else {
            // Retorna uma resposta de erro caso a deleção falhe
            return Yii::$app->response->setStatusCode(400)->data = [
                'status' => 'error',
                'message' => 'Erro ao deletar o carrinho.',
            ];
        }
    }

    // Adicionar item ao carrinho
    public function actionAddToCart()
    {

        $data = json_decode(file_get_contents("php://input"), true); // Captura o JSON enviado

        // Verifica se as credenciais foram fornecidas
        if (empty($data['produto_id'])) {
            return Yii::$app->response->setStatusCode(404)->data = [
                'status' => 'error',
                'message' => 'Produto_id não encontrado : ',
            ];
        }

        $userId = Yii::$app->user->id; // ID do utilizador autenticado

        
        // Obter ou criar o carrinho do utilizador
        $carrinho = Carrinho::findOne(['utilizadorperfil_id' => $userId]);
        if (!$carrinho) {
            // Cria carrinho se não existir
            $carrinho = new Carrinho();
            $carrinho->utilizadorperfil_id = $userId;
            if (!$carrinho->save()) {
                Yii::error('Erro ao criar o carrinho para o utilizador ID: ' . $userId . '. Erros: ' . json_encode($carrinho->errors), __METHOD__);
                return Yii::$app->response->setStatusCode(400)->data = [
                    'status' => 'error',
                    'message' => 'Erro ao criar o carrinho.',
                    'errors' => $carrinho->errors,
                ];
            }
        }
        // Verificar se o produto existe
        $produto = Produto::findOne(['id' => $data['produto_id']]);
        $IdProduto= $produto->id;

    

        // Verificar se o produto existe
        $produto = Produto::findOne($IdProduto);
        if (!$produto) {
            Yii::error("Produto não encontrado com ID: $IdProduto", __METHOD__);
            return Yii::$app->response->setStatusCode(404)->data = [
                'status' => 'error',
                'message' => 'Produto não encontrado.',
            ];
        }

        // Verificar se o produto já está no carrinho
        $linhaCarrinho = Linhacarrinho::findOne(['carrinho_id' => $carrinho->id, 'produto_id' => $IdProduto]);

        if ($linhaCarrinho) {
            // Se o produto já está no carrinho, apenas incrementa a quantidade
            $linhaCarrinho->quantidade += 1;
            if (!$linhaCarrinho->save()) {
                Yii::error('Erro ao atualizar a linha do carrinho: ' . json_encode($linhaCarrinho->errors), __METHOD__);
                return Yii::$app->response->setStatusCode(400)->data = [
                    'status' => 'error',
                    'message' => 'Erro ao atualizar o produto no carrinho.',
                    'errors' => $linhaCarrinho->errors,
                ];
            }
        } else {
            // Criar uma nova linha no carrinho
            $linhaCarrinho = new Linhacarrinho();
            $linhaCarrinho->carrinho_id = $carrinho->id;
            $linhaCarrinho->produto_id = $IdProduto;
            $linhaCarrinho->quantidade = 1;
            $linhaCarrinho->preco_unitario = $produto->preco;

            if (!$linhaCarrinho->save()) {
                Yii::error('Erro ao criar a linha do carrinho: ' . json_encode($linhaCarrinho->errors), __METHOD__);
                return Yii::$app->response->setStatusCode(400)->data = [
                    'status' => 'error',
                    'message' => 'Erro ao adicionar o produto ao carrinho.',
                    'errors' => $linhaCarrinho->errors,
                ];
            }
        }

        // Resposta de sucesso
        return Yii::$app->response->setStatusCode(200)->data = [
            'status' => 'success',
            'message' => 'Produto adicionado ao carrinho com sucesso.',
            'data' => [
                'carrinho_id' => $carrinho->id,
                'produto_id' => $linhaCarrinho->produto_id,
                'quantidade' => $linhaCarrinho->quantidade,
                'preco_unitario' => $linhaCarrinho->preco_unitario,
            ],
        ];
    }


    // Remover item do carrinho
    public function actionRemove()
    {
        $data = json_decode(file_get_contents("php://input"), true); // Captura o JSON enviado

        // Verifica se as credenciais foram fornecidas
        if (empty($data['produto_id'])) {
            return Yii::$app->response->setStatusCode(404)->data = [
                'status' => 'error',
                'message' => 'Produto_id não encontrado : ',
            ];
        }
        

        
        // Obter o carrinho do utilizador
        $carrinho = Carrinho::findOne(['utilizadorperfil_id' => Yii::$app->user->id]);

        // Verificar se o carrinho existe
        if (!$carrinho) {
            Yii::error("Carrinho não encontrado para o utilizador ID: " . Yii::$app->user->id, __METHOD__);
            return Yii::$app->response->setStatusCode(404)->data = [
                'status' => 'error',
                'message' => 'Carrinho não encontrado.',
            ];
        }

        // Verificar se o produto existe
        $produto = Produto::findOne(['id' => $data['produto_id']]);
        $id= $produto->id;

        // Verificar se o id foi recebido corretamente
        if ($produto->id === null || $produto->id === 0) {
        return Yii::$app->response->setStatusCode(404)->data = [
            'status' => 'error',
            'message' => 'Produto_id não encontrado.',
        ];
    }

        // Verificar se o produto já está no carrinho
        $linhaCarrinho = Linhacarrinho::findOne(['carrinho_id' => $carrinho->id, 'produto_id' => $id]);

        // Se o produto estiver no carrinho, remover
        if ($linhaCarrinho) {
            if ($linhaCarrinho->delete()) {
                return Yii::$app->response->setStatusCode(200)->data = [
                    'status' => 'success',
                    'message' => 'Produto removido do carrinho com sucesso.',
                ];
            } else {
                Yii::error('Erro ao remover o produto do carrinho: ' . json_encode($linhaCarrinho->errors), __METHOD__);
                return Yii::$app->response->setStatusCode(400)->data = [
                    'status' => 'error',
                    'message' => 'Erro ao remover o produto do carrinho.',
                    'errors' => $linhaCarrinho->errors,
                ];
            }
        } else {
            // Produto não encontrado no carrinho
            return Yii::$app->response->setStatusCode(404)->data = [
                'status' => 'error',
                'message' => 'Produto não encontrado no carrinho.',
            ];
        }
    }

    // Rever a compra e preparar o checkout
    public function actionCheckout()
    {
        $userId = Yii::$app->user->id;

        // Obter o carrinho do utilizador
        $carrinho = Carrinho::findOne(['utilizadorperfil_id' => $userId]);

        if (!$carrinho) {
            return Yii::$app->response->setStatusCode(404)->data = [
                'status' => 'error',
                'message' => 'Carrinho não encontrado.',
            ];
        }

        // Verificar se o carrinho tem produtos
        if (empty($carrinho->linhacarrinhos)) {
            return Yii::$app->response->setStatusCode(400)->data = [
                'status' => 'error',
                'message' => 'Carrinho vazio.',
            ];
        }

        // Verificar o cupão e calcular o desconto
        $cupao = $carrinho->cupao;
        $descontocupao = $cupao ? $cupao->valor : 0;

        // Verificar estoque dos produtos
        foreach ($carrinho->linhacarrinhos as $linha) {
            $produto = Produto::findOne($linha->produto_id);
            if ($produto->stockdisponivel < $linha->quantidade) {
                return Yii::$app->response->setStatusCode(400)->data = [
                    'status' => 'error',
                    'message' => "O produto '{$produto->nome}' não tem stock suficiente. Remova o produto do carrinho.",
                ];
            }
        }

        // Calcular subtotal
        $subtotal = 0;
        foreach ($carrinho->linhacarrinhos as $linha) {
            $subtotal += $linha->preco_unitario * $linha->quantidade;
        }

        // Calcular total com desconto
        $totalComDesconto = $subtotal - $descontocupao;

        // Calcular IVA
        $totalIVA = 0;
        foreach ($carrinho->linhacarrinhos as $linha) {
            $totalIVA += ($linha->preco_unitario * $linha->produto->iva->taxa / 100) * $linha->quantidade;
        }

        // Preparar os métodos de pagamento
        $metodospagamento = Metodopagamento::find()->all();
        $metodospagamentoArray = [];
        foreach ($metodospagamento as $metodo) {
            $metodospagamentoArray[] = [
                'id' => $metodo->id,
                'nomemetodopagamento' => $metodo->nomemetodopagamento,
            ];
        }

        // Responder com os detalhes do checkout
        return Yii::$app->response->setStatusCode(200)->data = [
            'status' => 'success',
            'data' => [
                'carrinho_id' => $carrinho->id,
                'linhas_carrinho' => array_map(function ($linha) {
                    return [
                        'produto_id' => $linha->produto_id,
                        'nome' => $linha->produto->nome,
                        'quantidade' => $linha->quantidade,
                        'preco_unitario' => $linha->preco_unitario,
                    ];
                }, $carrinho->linhacarrinhos),
                'subtotal' => $subtotal,
                'desconto_cupao' => $descontocupao,
                'total_com_desconto' => $totalComDesconto,
                'total_iva' => $totalIVA,
                'metodos_pagamento' => $metodospagamentoArray,
            ],
        ];
    }

    // Concluir a compra
    public function actionFinalizarCompra()
    {
        $idUtilizador = Yii::$app->user->id;


        $data = json_decode(file_get_contents("php://input"), true); // Captura o JSON enviado

        // Verifica se as credenciais foram fornecidas
        if (empty($data['metodopagamento_id'])) {
            return Yii::$app->response->setStatusCode(404)->data = [
                'status' => 'error',
                'message' => 'metodopagamento_id não encontrado : ',
            ];
        }
        // Verificar se o produto existe
        $metodoPagamento = Metodopagamento::findOne(['id' => $data['metodopagamento_id']]);
        $metodopagamento_id= $metodoPagamento->id;

        // Verificar se o utilizador tem carrinho ativo
        $carrinho = Carrinho::findOne(['utilizadorperfil_id' => $idUtilizador]);

        // Verificar se o carrinho existe
        if (!$carrinho) {
            return Yii::$app->response->setStatusCode(404)->data = [
                'status' => 'error',
                'message' => 'Carrinho não encontrado.',
            ];
        }

        // Verificar se o carrinho tem produtos
        if (count($carrinho->linhacarrinhos) == 0) {
            return Yii::$app->response->setStatusCode(400)->data = [
                'status' => 'error',
                'message' => 'Carrinho vazio.',
            ];
        }

        $metodoPagamento = Metodopagamento::findOne($metodopagamento_id);
        if (!$metodoPagamento) {
            return Yii::$app->response->setStatusCode(400)->data = [
                'status' => 'error',
                'message' => 'Método de pagamento inválido.',
            ];
        }

        // Verificar se o carrinho tem um cupão
        $cupao = $carrinho->cupao_id ? Cupao::findOne($carrinho->cupao_id) : null;
        $desconto = $cupao ? $cupao->valor : 0;

        $subtotal = 0;
        $valorIVA = 0;

        // Vai buscar as linhas carrinho
        $linhasCarrinho = $carrinho->linhacarrinhos;

        // Calcula o subtotal e o valor do IVA
        foreach ($linhasCarrinho as $linha) {
            $subtotal += $linha->produto->preco * $linha->quantidade;
            $valorIVA += ($linha->produto->preco * $linha->produto->iva->taxa / 100) * $linha->quantidade;
        }

        // Calcula o valor total com desconto
        $valorTotal = $subtotal - $desconto;

        // Criar a fatura
        $fatura = new Fatura();
        $fatura->datafatura = date('Y-m-d H:i:s');
        $fatura->totalciva = $valorIVA;
        $fatura->subtotal = $subtotal;
        $fatura->valor_total = $valorTotal;
        $fatura->estado = 'Pago';
        $fatura->descontovalor = $desconto;
        $fatura->datapagamento = date('Y-m-d H:i:s');
        $fatura->utilizadorperfil_id = $idUtilizador;
        $fatura->metodopagamento_id = (int)$metodopagamento_id;
        $fatura->cupao_id = $carrinho->cupao_id;

        if ($fatura->save()) {
            // Atribui as linhas da fatura
            foreach ($linhasCarrinho as $linha) {
                $produto = Produto::findOne($linha->produto_id);
                $linhaFatura = new LinhaFatura();
                $linhaFatura->quantidade = $linha->quantidade;
                $linhaFatura->precounitario = $linha->produto->preco;
                $linhaFatura->subtotal = $linha->produto->preco * $linha->quantidade;
                $linhaFatura->fatura_id = $fatura->id;
                $linhaFatura->desconto_id = $linha->produto->desconto_id;
                $linhaFatura->iva_id = $linha->produto->iva_id;
                $linhaFatura->produto_id = $linha->produto_id;

                // Verifica se tem stock de chaves digitais
                $chavesDigitaisDisponiveis = Chavedigital::find()
                    ->where(['produto_id' => $linha->produto_id, 'estado' => 'nao usada'])
                    ->limit($linha->quantidade)
                    ->all();

                if (count($chavesDigitaisDisponiveis) >= $linha->quantidade) {
                    foreach ($chavesDigitaisDisponiveis as $chave) {
                        $novaLinhaFatura = clone $linhaFatura; // Clona a linha para cada chave
                        $novaLinhaFatura->chavedigital_id = $chave->id;

                        if (!$novaLinhaFatura->save()) {
                            return Yii::$app->response->setStatusCode(500)->data = [
                                'status' => 'error',
                                'message' => 'Erro ao salvar linha de fatura: ' . json_encode($novaLinhaFatura->errors),
                            ];
                        }

                        $chave->estado = 'usada';
                        $chave->datavenda = date('Y-m-d H:i:s');
                        $chave->save();
                    }
                } else {
                    // Caso não haja chaves suficientes, retorna erro
                    return Yii::$app->response->setStatusCode(400)->data = [
                        'status' => 'error',
                        'message' => 'O produto ' . $produto->nome . ' não tem chaves digitais disponíveis suficientes. Por favor, contacte o suporte.',
                    ];
                }

                // Atualiza o stock do produto
                $produto->stockdisponivel -= $linha->quantidade;
                $produto->save();
            }

            // Limpar o carrinho
            foreach ($linhasCarrinho as $linha) {
                $linha->delete();
            }

            // Limpar o cupão se existir
            if ($carrinho->cupao_id) {
                $cupao->ativo = 0;
                $carrinho->cupao_id = null;
                $cupao->save();
                $carrinho->save();
            }

            return Yii::$app->response->setStatusCode(200)->data = [
                'status' => 'success',
                'message' => 'Compra efetuada com sucesso!',
                'fatura_id' => $fatura->id,
            ];
        } else {
            return Yii::$app->response->setStatusCode(500)->data = [
                'status' => 'error',
                'message' => 'Erro ao criar a fatura.',
            ];
        }

    }




    // Aplicar cupão
        public function actionVerificarCupao()
    {
        // Verifica se a requisição é do tipo POST
        if (Yii::$app->request->isPost) {
            $codigoCupao = Yii::$app->request->post('codigo');
        } else {
            return Yii::$app->response->setStatusCode(400)->data = [
                'status' => 'error',
                'message' => 'Código de cupão não fornecido.',
            ];
        }

        // Obter o carrinho do utilizador
        $carrinho = Carrinho::findOne(['utilizadorperfil_id' => Yii::$app->user->id]);

        if (!$carrinho) {
            return Yii::$app->response->setStatusCode(404)->data = [
                'status' => 'error',
                'message' => 'Carrinho não encontrado.',
            ];
        }

        // Buscar o cupão usando o código fornecido
        $cupao = Cupao::findOne(['codigo' => $codigoCupao]);

        if (!$cupao) {
            return Yii::$app->response->setStatusCode(404)->data = [
                'status' => 'error',
                'message' => 'Cupão não encontrado.',
            ];
        }

        // Verificar se o cupão está expirado
        if (strtotime($cupao->datavalidade) < time()) {
            return Yii::$app->response->setStatusCode(400)->data = [
                'status' => 'error',
                'message' => 'Cupão expirado.',
            ];
        }

        // Verificar se o cupão está ativo
        if (!$cupao->ativo) {
            return Yii::$app->response->setStatusCode(400)->data = [
                'status' => 'error',
                'message' => 'Cupão inativo.',
            ];
        }

        // Aplicar o cupão ao carrinho
        $carrinho->cupao_id = $cupao->id;
        if ($carrinho->save()) {
            return Yii::$app->response->setStatusCode(200)->data = [
                'status' => 'success',
                'message' => 'Cupão aplicado com sucesso!',
                'cupao' => [
                    'codigo' => $cupao->codigo,
                    'valor' => $cupao->valor,
                ],
            ];
        } else {
            return Yii::$app->response->setStatusCode(400)->data = [
                'status' => 'error',
                'message' => 'Erro ao aplicar o cupão. Tente novamente.',
                'errors' => $carrinho->errors,
            ];
        }
    }
    public function actionCalcularTotal()
    {
        $carrinho = Carrinho::findOne(['utilizadorperfil_id' => Yii::$app->user->id]);

        $linhascarrinho = Linhacarrinho::find()->where(['carrinho_id' => $carrinho->id])->all();

        $total=0;

        foreach ($linhascarrinho as $linha) {
            $total += $linha->quantidade * $linha->preco_unitario;
        }
        return Yii::$app->response->setStatusCode(200)->data = [
            'status' => 'success',
            'message' => 'Total calculado com sucesso.',
            'total' => $total,
        ];


    }

    protected function findModel($id)
    {
        // Tenta encontrar o modelo na base de dados com o ID fornecido
        if (($model = Carrinho::findOne(['id' => $id])) !== null) {
            return $model;
        }

        // Caso o modelo não seja encontrado, retorna um erro JSON
        Yii::error("Carrinho com ID $id não encontrado.", __METHOD__);
        return Yii::$app->response->setStatusCode(404)->data = [
            'status' => 'error',
            'message' => 'Carrinho não encontrado.',
        ];
    }

}
