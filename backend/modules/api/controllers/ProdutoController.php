<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
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

<<<<<<< Updated upstream
    public function behaviors()
=======
    public function actionIndex()
    {
        // Obter todos os produtos da base de dados
        $produtos = Produto::find()->all();

        // Verificar se há produtos
        if (empty($produtos)) {
            Yii::$app->response->statusCode = 404; // Nenhum produto encontrado
            return [
                'status' => 'error',
                'message' => 'Nenhum produto encontrado.',
            ];
        }

        // Formatar os produtos para a resposta
        $produtosFormatados = [];
        foreach ($produtos as $produto) {
            $produtosFormatados[] = [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'descricao' => $produto->descricao,
                'preco' => $produto->preco,
                'stockdisponivel' => $produto->stockdisponivel,
                'imagem' => $produto->imagem,
            ];
        }

        // Retornar os produtos formatados
        Yii::$app->response->statusCode = 200; // Sucesso
        return [
            'status' => 'success',
            'message' => 'Produtos recuperados com sucesso.',
            'data' => $produtosFormatados,
        ];
    }

    //Mostrar todos os produtos
    public function actionView($id)
>>>>>>> Stashed changes
    {
        Yii::$app->params['id'] = 0;
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
            //only=> ['index'], //Apenas para o GET
        ];
        return $behaviors;
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
            'status' => 'Sucesso',
            'message' => 'Contagem de produtos realizada com sucesso.',
            'count' => $count,
        ];
    }

}
