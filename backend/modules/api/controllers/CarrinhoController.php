<?php

namespace app\modules\api\controllers;

use common\models\Carrinho;
use common\models\Linhacarrinho;
use common\models\Produto;
use Yii;
use yii\rest\Controller;

class CarrinhoController extends \yii\web\Controller
{
    public function actionIndex()
    {
        // Obter carrinho do utilizador
        $carrinho = Carrinho::findOne(['utilizadorperfil_id' => Yii::$app->user->id]);

        // Verifica se o utilizador tem algum produto no carrinho
        if (!$carrinho) {
            // Cria carrinho se não existir
            $carrinho = new Carrinho();
            $carrinho->utilizadorperfil_id = Yii::$app->user->id;
            $carrinho->data_criacao = date('Y-m-d H:i:s');

            if (!$carrinho->save()) {
                // Retorna erro em formato JSON
                Yii::error("Erro ao criar carrinho: " . json_encode($carrinho->errors), __METHOD__);
                return Yii::$app->response->setStatusCode(400)
                    ->data = [
                    'status' => 'error',
                    'message' => 'Erro ao criar o carrinho.',
                    'errors' => $carrinho->errors
                ];
            }
        }

        // Buscar as linhas do carrinho associado
        $linhasCarrinho = Linhacarrinho::find()->where(['carrinho_id' => $carrinho->id])->all();

        // Retorna msg em formato JSON
        return Yii::$app->response->setStatusCode(200)
            ->data = [
            'status' => 'success',
            'message' => 'Carrinho recuperado com sucesso.',
            'carrinho' => $carrinho,
            'linhasCarrinho' => $linhasCarrinho
        ];
    }


    // Adicionar item ao carrinho
    public function actionAddToCart($IdProduto)
    {
        $userId = Yii::$app->user->id; // ID do utilizador autenticado

        // Obter ou criar o carrinho do utilizador
        $carrinho = Carrinho::findOne(['utilizadorperfil_id' => $userId]);
        if (!$carrinho) {
            $carrinho = new Carrinho();
            $carrinho->utilizadorperfil_id = $userId;
            if (!$carrinho->save()) {
                Yii::error('Erro ao criar o carrinho para o usuário ID: ' . $userId . '. Erros: ' . json_encode($carrinho->errors), __METHOD__);
                return [
                    'status' => 'error',
                    'message' => 'Erro ao criar o carrinho.',
                    'errors' => $carrinho->errors,
                ];
            }
        }

        // Verificar se o produto existe
        $produto = Produto::findOne($IdProduto);
        if (!$produto) {
            Yii::error("Produto não encontrado com ID: $IdProduto", __METHOD__);
            return [
                'status' => 'error',
                'message' => 'Produto não encontrado.',
            ];
        }

        // Verificar se o produto já está no carrinho
        $linhaCarrinho = Linhacarrinho::findOne(['carrinho_id' => $carrinho->id, 'produto_id' => $IdProduto]);

        if ($linhaCarrinho) {
            $linhaCarrinho->quantidade += 1;
            if (!$linhaCarrinho->save()) {
                Yii::error('Erro ao atualizar a linha do carrinho: ' . json_encode($linhaCarrinho->errors), __METHOD__);
                return [
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
                return [
                    'status' => 'error',
                    'message' => 'Erro ao adicionar o produto ao carrinho.',
                    'errors' => $linhaCarrinho->errors,
                ];
            }
        }

        return [
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
    public function actionRemove($id)
    {
        // Implementação para remover um produto do carrinho
    }

    // Finalizar compra
    public function actionFinalizar()
    {
        // Implementação para finalizar a compra e gerar a fatura
    }

    // Aplicar cupom
    public function actionAplicarCupao()
    {
        // Implementação para validar e aplicar cupao no carrinho
    }



}
