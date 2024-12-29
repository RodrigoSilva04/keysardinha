<?php

namespace app\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Carrinho;
use common\models\Cupao;
use common\models\Linhacarrinho;
use common\models\Produto;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;

class CarrinhoController extends \yii\web\Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
            'tokenParam' => 'access-token',
        ];
        return $behaviors;
    }
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
                return Yii::$app->response->setStatusCode(400)->data = [
                    'status' => 'error',
                    'message' => 'Erro ao criar o carrinho.',
                    'errors' => $carrinho->errors
                ];
            }
        }

        // Buscar as linhas do carrinho associado
        $linhasCarrinho = Linhacarrinho::find()->where(['carrinho_id' => $carrinho->id])->all();

        // Retorna sucesso com os dados do carrinho em formato JSON
        return Yii::$app->response->setStatusCode(200)->data = [
            'status' => 'success',
            'message' => 'Carrinho recuperado com sucesso.',
            'carrinho' => $carrinho,
            'linhasCarrinho' => $linhasCarrinho,
        ];
    }

    public function actionView($id)
    {
        // Buscar o modelo com o ID fornecido
        $model = $this->findModel($id);

        if (!$model) {
            return Yii::$app->response->setStatusCode(404)->data = [
                'status' => 'error',
                'message' => 'Modelo não encontrado.',
            ];
        }

        // Retornar dados do modelo em formato JSON
        return Yii::$app->response->setStatusCode(200)->data = [
            'status' => 'success',
            'message' => 'Modelo recuperado com sucesso.',
            'data' => $model,
        ];
    }

    public function actionCreate()
    {
        $model = new Carrinho();

        if (Yii::$app->request->isPost) {
            // Carregar os dados enviados via POST
            $data = Yii::$app->request->post();

            if ($model->load($data, '') && $model->save()) {
                return Yii::$app->response->setStatusCode(201)->data = [
                    'status' => 'success',
                    'message' => 'Carrinho criado com sucesso.',
                    'data' => $model,
                ];
            } else {
                // Se houver erro ao salvar, retorna os erros
                return Yii::$app->response->setStatusCode(400)->data = [
                    'status' => 'error',
                    'message' => 'Erro ao criar carrinho.',
                    'errors' => $model->errors,
                ];
            }
        } else {
            // Caso a requisição não seja POST
            return Yii::$app->response->setStatusCode(400)->data = [
                'status' => 'error',
                'message' => 'Método inválido. Apenas POST é permitido.',
            ];
        }
    }

    public function actionUpdate($id)
    {
        // Encontra o carrinho com o ID fornecido
        $model = $this->findModel($id);

        // Verifica se a requisição é POST e carrega os dados
        if (Yii::$app->request->isPost) {
            // Carrega os dados da requisição no modelo
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                // Se a atualização for bem-sucedida, retorna um status de sucesso
                return Yii::$app->response->setStatusCode(200)->data = [
                    'status' => 'success',
                    'message' => 'Carrinho atualizado com sucesso.',
                    'data' => $model,
                ];
            } else {
                // Se ocorrer um erro ao salvar, retorna os erros em formato JSON
                Yii::error("Erro ao atualizar o carrinho: " . json_encode($model->errors), __METHOD__);
                return Yii::$app->response->setStatusCode(400)->data = [
                    'status' => 'error',
                    'message' => 'Erro ao atualizar o carrinho.',
                    'errors' => $model->errors,
                ];
            }
        }

        // Se não for uma requisição POST, retorna um erro
        return Yii::$app->response->setStatusCode(405)->data = [
            'status' => 'error',
            'message' => 'Método não permitido.',
        ];
    }

    public function actionDelete($id)
    {
        // Busca o modelo com o ID fornecido
        $model = $this->findModel($id);

        // Se o modelo não for encontrado, retornamos uma resposta de erro
        if (!$model) {
            return Yii::$app->response->setStatusCode(404)->data = [
                'status' => 'error',
                'message' => 'Carrinho não encontrado.',
            ];
        }

        // Deleta o modelo
        if ($model->delete()) {
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
    public function actionAddToCart($IdProduto)
    {
        $userId = Yii::$app->user->id; // ID do utilizador autenticado

        // Obter ou criar o carrinho do utilizador
        $carrinho = Carrinho::findOne(['utilizadorperfil_id' => $userId]);
        if (!$carrinho) {
            // Cria carrinho se não existir
            $carrinho = new Carrinho();
            $carrinho->utilizadorperfil_id = $userId;
            if (!$carrinho->save()) {
                Yii::error('Erro ao criar o carrinho para o usuário ID: ' . $userId . '. Erros: ' . json_encode($carrinho->errors), __METHOD__);
                return Yii::$app->response->setStatusCode(400)->data = [
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
    public function actionRemove($id)
    {
        // Obter o carrinho do utilizador
        $carrinho = Carrinho::findOne(['utilizadorperfil_id' => Yii::$app->user->id]);

        // Verificar se o carrinho existe
        if (!$carrinho) {
            Yii::error("Carrinho não encontrado para o usuário ID: " . Yii::$app->user->id, __METHOD__);
            return Yii::$app->response->setStatusCode(404)->data = [
                'status' => 'error',
                'message' => 'Carrinho não encontrado.',
            ];
        }

        // Verificar se o produto existe
        $produto = Produto::findOne($id);
        if (!$produto) {
            Yii::error("Produto não encontrado com ID: $id", __METHOD__);
            return Yii::$app->response->setStatusCode(404)->data = [
                'status' => 'error',
                'message' => 'Produto não encontrado.',
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

    // Finalizar compra
    public function actionCheckout()
    {
        // Implementação para finalizar a compra e gerar a fatura
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
                    'desconto' => $cupao->desconto,
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

    protected function findModel($id)
    {
        // Tenta encontrar o modelo no banco de dados com o ID fornecido
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
