<?php

namespace backend\modules\api\controllers;

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

    // Pesquisar jogos
    public function actionSearch($query)
    { $produtos = $this->modelClass::find()->where(['like', 'nome', $query])->all();

        // Se não houver produtos encontrados
        if (empty($produtos)) {
            return Yii::$app->response->setStatusCode(404)
                ->data = [
                'status' => 'error',
                'message' => 'Nenhum produto encontrado para a pesquisa.'
            ];
        }

        // Retorna os produtos encontrados com sucesso
        return Yii::$app->response->setStatusCode(200)
            ->data = [
            'status' => 'success',
            'message' => 'Produtos encontrados.',
            'produtos' => $produtos
        ];
    }

    // Filtrar jogos por categoria
    public function actionFilter($categoria)
    {
        // Buscar produtos pela categoria
        $produtos = $this->modelClass::find()->where(['categoria' => $categoria])->all();

        // Se não houver produtos encontrados
        if (empty($produtos)) {
            return Yii::$app->response->setStatusCode(404)
                ->data = [
                'status' => 'error',
                'message' => "Nenhum produto encontrado para a categoria '$categoria'."
            ];
        }

        // Retorna os produtos encontrados com sucesso
        return Yii::$app->response->setStatusCode(200)
            ->data = [
            'status' => 'success',
            'message' => 'Produtos filtrados com sucesso.',
            'produtos' => $produtos
        ];
    }


    // Detalhes de um jogo
    public function actionDetalhes($id)
    {
        // Buscar o produto pelo ID
        $produto = $this->modelClass::findOne($id);

        // Se o produto não for encontrado
        if (!$produto) {
            return Yii::$app->response->setStatusCode(404)
                ->data = [
                'status' => 'error',
                'message' => "Produto não encontrado com o ID $id."
            ];
        }

        // Retorna os detalhes do produto com sucesso
        return Yii::$app->response->setStatusCode(200)
            ->data = [
            'status' => 'success',
            'message' => 'Detalhes do produto recuperados com sucesso.',
            'produto' => $produto
        ];
    }


}
