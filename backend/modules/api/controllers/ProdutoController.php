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
