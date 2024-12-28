<?php

namespace backend\modules\api\controllers;

use common\models\Produto;
use Yii;
use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class ProdutoController extends ActiveController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $modelClass = 'common\models\Produto';

    //Mostrar todos os produtos
    public function actionView($id)
    {
        // Procurar o produto pelo ID
        $produto = Produto::findOne($id);

        // Verificar se o produto existe
        if (!$produto) {
            Yii::$app->response->statusCode = 404; // Não encontrado
            return [
                'status' => 'error',
                'message' => 'Produto não encontrado.',
            ];
        }

        // Retornar os detalhes do produto
        Yii::$app->response->statusCode = 200; // OK
        return [
            'status' => 'success',
            'message' => 'Produto encontrado.',
            'data' => [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'descricao' => $produto->descricao,
                'preco' => $produto->preco,
                'stock' => $produto->stockdisponivel,
                'imagem' => $produto->imagem,
            ],
        ];
    }

    //Cria um novo Produto
    public function actionCreate()
    {
        $model = new Produto(); // Cria um novo modelo de Produto

        // carrega os dados da requisição POST no modelo
        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            // Tenta guardar o modelo
            if ($model->save()) {
                Yii::$app->response->statusCode = 201; //sucesso para criação
                return [
                    'status' => 'success',
                    'message' => 'Produto criado com sucesso.',
                    'data' => [
                        'id' => $model->id,
                        'nome' => $model->nome,
                        'descricao' => $model->descricao,
                        'preco' => $model->preco,
                        'stock' => $model->stockdisponivel,
                        'imagem' => $model->imagem,
                    ],
                ];
            } else {
                // Caso não consiga salvar
                Yii::$app->response->statusCode = 500; // Código de erro interno
                return [
                    'status' => 'error',
                    'message' => 'Erro ao salvar o produto.',
                    'errors' => $model->errors,
                ];
            }
        } else {
            // Caso os dados não sejam válidos
            Yii::$app->response->statusCode = 422; // Código de erro de validação
            return [
                'status' => 'error',
                'message' => 'Dados inválidos.',
                'errors' => $model->errors,
            ];
        }
    }

    public function actionUpdate($id)
    {
        // Busca o modelo do produto pelo ID
        $model = Produto::findOne($id);

        // Verifica se o produto existe
        if (!$model) {
            Yii::$app->response->statusCode = 404; // Código de não encontrado
            return [
                'status' => 'error',
                'message' => 'Produto não encontrado.',
            ];
        }

        // Carrega os dados da requisição POST no modelo
        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            // Tenta salvar o modelo atualizado
            if ($model->save()) {
                Yii::$app->response->statusCode = 200; // Código de sucesso
                return [
                    'status' => 'success',
                    'message' => 'Produto atualizado com sucesso.',
                    'data' => [
                        'id' => $model->id,
                        'nome' => $model->nome,
                        'descricao' => $model->descricao,
                        'preco' => $model->preco,
                        'stock' => $model->stockdisponivel,
                        'imagem' => $model->imagem,
                    ],
                ];
            } else {
                // Caso não consiga guardar
                Yii::$app->response->statusCode = 500; // Código de erro interno
                return [
                    'status' => 'error',
                    'message' => 'Erro ao atualizar o produto.',
                    'errors' => $model->errors,
                ];
            }
        } else {
            // Caso os dados não sejam válidos
            Yii::$app->response->statusCode = 422; // Código de erro de validação
            return [
                'status' => 'error',
                'message' => 'Dados inválidos.',
                'errors' => $model->errors,
            ];
        }
    }

    public function actionDelete($id)
    {
        // Busca o modelo do produto pelo ID
        $model = Produto::findOne($id);

        // Verifica se o produto existe
        if (!$model) {
            Yii::$app->response->statusCode = 404; // Código de não encontrado
            return [
                'status' => 'error',
                'message' => 'Produto não encontrado.',
            ];
        }

        // Tenta excluir o produto
        if ($model->delete()) {
            Yii::$app->response->statusCode = 200; // Código de sucesso
            return [
                'status' => 'success',
                'message' => 'Produto excluído com sucesso.',
            ];
        } else {
            Yii::$app->response->statusCode = 500; // Código de erro interno
            return [
                'status' => 'error',
                'message' => 'Erro ao excluir o produto.',
            ];
        }
    }

    // Pesquisar jogos
    public function actionSearch($query)
    {
        $produtos = $this->modelClass::find()
            ->where(['like', 'nome', $query])
            ->asArray()
            ->all();

        if (empty($produtos)) {
            return [
                'status' => 'error',
                'message' => 'Nenhum produto encontrado para a pesquisa.',
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Produtos encontrados.',
            'produtos' => $produtos,
        ];
    }

    // Filtrar jogos por categoria
    public function actionFilter($categoria)
    {
        $produtos = $this->modelClass::find()
            ->where(['categoria' => $categoria])
            ->asArray()
            ->all();

        if (empty($produtos)) {
            return [
                'status' => 'error',
                'message' => 'Nenhum produto encontrado para a categoria especificada.',
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Produtos encontrados na categoria.',
            'produtos' => $produtos,
        ];
    }

    // Detalhes de um jogo
    public function actionDetalhes($id)
    {
        $produto = $this->modelClass::findOne($id);

        if (!$produto) {
            return [
                'status' => 'error',
                'message' => 'Produto não encontrado.',
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Detalhes do produto encontrados.',
            'produto' => $produto->toArray(),
        ];
    }
    public function actionCount()
    {
        $count = $this->modelClass::find()->count();

        return [
            'status' => 'success',
            'message' => 'Contagem de produtos realizada com sucesso.',
            'count' => $count,
        ];
    }

}
