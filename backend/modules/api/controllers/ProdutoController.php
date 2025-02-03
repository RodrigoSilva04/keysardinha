<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
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


    public function behaviors()
    {
        Yii::$app->params['id'] = 0;
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
            //only=> ['index'], //Apenas para o GET
        ];
        return $behaviors;
    }
    public function actionCreate()
    {
        $produto = new Produto();

        // Carregar dados da requisição POST
        if ($produto->load(Yii::$app->request->post(), '') && $produto->save()) {
            return Yii::$app->response->setStatusCode(200)->data = [
                'status' => 'success',
                'message' => 'Produto criado com sucesso.',
            ];
        } else {
            return Yii::$app->response->setStatusCode(400)->data = [
                'status' => 'error',
                'message' => 'Erro ao criar o produto.',
            ];
        }
    }
    
    public function actionListarJogos()
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
                'categoria' => $produto->categoria->nome,
                'preco' => $produto->preco,
                'stockdisponivel' => $produto->stockdisponivel,
                'imagem' => Yii::getAlias('@frontend/web/imagensjogos/') . '/' . $produto->imagem,
                'datalancamento' => $produto->datalancamento,
                'desconto' => $produto->desconto->percentagem,
                'iva' => $produto->iva->taxa,
            ];
        }
        return $produtosFormatados;
    }

    //Mostrar todos os produtos
    public function actionView($id)
    {
        $produto = Produto::findOne($id);

        if (!$produto) {
            Yii::$app->response->statusCode = 404; // Produto não encontrado
            return [
                'status' => 'error',
                'message' => 'Produto não encontrado.',
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Produto recuperado com sucesso.',
            'data' => [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'categoria' => $produto->categoria,
                'descricao' => $produto->descricao,
                'preco' => $produto->preco,
                'stockdisponivel' => $produto->stockdisponivel,
                'imagem' => $produto->imagem,
            ],
        ];
    }

    // Pesquisar jogos
    public function actionSearch($query, $categoria = null)
    {
        $queryBuilder = $this->modelClass::find()
            ->where(['like', 'nome', $query]); // Pesquisa pelo nome do produto

        // Se a categoria for fornecida, aplica o filtro da categoria
        if ($categoria !== null) {
            $queryBuilder->andWhere(['categoria_id' => $categoria]);
        }

        $produtos = $queryBuilder->asArray()->all();

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

    // Filtrar produtos por categoria
    public function actionFilter($categoria)
    {
        $produtos = $this->modelClass::find()
            ->where(['categoria_id' => $categoria]) // Usando o campo correto 'categoria_id'
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
            'message' => 'Produto recuperado com sucesso.',
            'data' => [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'categoria' => $produto->categoria->nome,
                'descricao' => $produto->descricao,
                'preco' => $produto->preco,
                'stockdisponivel' => $produto->stockdisponivel,
                'imagem' => Yii::getAlias('@frontend/web/imagensjogos/') . '/' . $produto->imagem,
                'datalancamento' => $produto->datalancamento,
                'desconto' => $produto->desconto->percentagem,
                'iva' => $produto->iva->taxa,
            ],
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
