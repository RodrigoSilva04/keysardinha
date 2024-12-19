<?php

namespace frontend\controllers;

use common\models\Carrinho;
use common\models\Cupao;
use common\models\Desconto;
use common\models\Linhacarrinho;
use common\models\Produto;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\conditions\ExistsConditionBuilder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CarrinhoController implements the CRUD actions for Carrinho model.
 */
class CarrinhoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Carrinho models.
     *
     * @return string
     */
    public function actionIndex()
    {
        //Obter o carrinho do utilizador
        $carrinho = Carrinho::findone(['utilizadorperfil_id' => Yii::$app->user->id]);

        //Verifica se o utilizador tem algum produto no carrinho
        if (!$carrinho) {
            // Criar carrinho caso não exista
            $carrinho = new Carrinho();
            $carrinho->utilizadorperfil_id = Yii::$app->user->id;
            $carrinho->data_criacao = date('Y-m-d H:i:s');
            if (!$carrinho->save()) {
                $erros = json_encode($carrinho->errors);
                Yii::error("Erro ao criar carrinho: $erros", __METHOD__);
                Yii::$app->session->setFlash('error', "Erro ao criar o carrinho: $erros");
                // Retorna para a página do carrinho em vez de site/index
                return $this->redirect(['produto/index']);
            }
        } else {
            Yii::$app->session->setFlash('success', 'Carrinho criado com sucesso.');

        }




        //Buscar as linhas do carrinho associado
        $linhasCarrinho = Linhacarrinho::find()->where(['carrinho_id' => $carrinho->id])->all();

        return $this->render('index', [
            'carrinho' => $carrinho,
            'linhasCarrinho' => $linhasCarrinho,
        ]);
    }

    /**
     * Displays a single Carrinho model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Carrinho model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Carrinho();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Carrinho model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Carrinho model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Carrinho model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Carrinho the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Carrinho::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAddToCart($IdProduto)
    {
        // Obter o carrinho do utilizador
        $carrinho = Carrinho::findOne(['utilizadorperfil_id' => Yii::$app->user->id]);

        // Se não tiver carrinho, cria um
        if (!$carrinho){
            $carrinho = new Carrinho();
            $carrinho->utilizadorperfil_id = Yii::$app->user->id;
            if (!$carrinho->save()) {
                Yii::error('Erro ao criar o carrinho para o usuário ID: ' . Yii::$app->user->id . '. Erros: ' . json_encode($carrinho->errors), __METHOD__);
                Yii::$app->session->setFlash('error', 'Erro ao criar o carrinho.');

            }
        }

        // Verificar se o produto existe
        $produto = Produto::findOne($IdProduto);

        if (!$produto) {
            Yii::error("Produto não encontrado com ID: $IdProduto", __METHOD__);
            Yii::$app->session->setFlash('error', 'Produto não encontrado');

        }

        // Verificar se o produto já está no carrinho
        $linhaCarrinho = Linhacarrinho::findOne(['carrinho_id' => $carrinho->id, 'produto_id' => $IdProduto]);

        if ($linhaCarrinho) {
            $linhaCarrinho->quantidade += 1;
            if (!$linhaCarrinho->save()) {
                Yii::error('Erro ao atualizar a linha do carrinho: ' . json_encode($linhaCarrinho->errors), __METHOD__);
                Yii::$app->session->setFlash('error', 'Erro ao atualizar o produto no carrinho.');

            }
        } else {
            // Se não estiver, cria uma nova linha no carrinho
            $linhaCarrinho = new Linhacarrinho();
            $linhaCarrinho->carrinho_id = $carrinho->id;
            $linhaCarrinho->produto_id = $IdProduto;
            $linhaCarrinho->quantidade = 1;
            $linhaCarrinho->preco_unitario = $produto->preco;

            if (!$linhaCarrinho->save()) {
                Yii::error('Erro ao criar a linha do carrinho: ' . json_encode($linhaCarrinho->errors), __METHOD__);
                Yii::$app->session->setFlash('error', 'Erro ao adicionar o produto ao carrinho.');

            }
        }

        Yii::$app->session->setFlash('success', 'Produto adicionado ao carrinho com sucesso!');
        return $this->redirect(['carrinho/index']);
    }


    public function actionVerificarCupao()
    {
        //Vai buscar o cupão
        if (yii::$app->request->isPost){
        $codigoCupao = Yii::$app->request->post('codigo');
        }

        // Obter o carrinho do utilizador
        $carrinho = Carrinho::findOne(['utilizadorperfil_id' => Yii::$app->user->id]);


        if (!$carrinho) {
            Yii::$app->session->setFlash('error', 'Carrinho não encontrado.');
            return $this->redirect(['carrinho/index']);
        }
        //Pelo codigo do cupão, vai buscar o cupão
        $cupao = Cupao::findOne(['codigo' => $codigoCupao]);

        //Se o cupão não existir, retorna uma mensagem de erro
        if (!$cupao) {
            Yii::$app->session->setFlash('error', 'Cupão não encontrado.');
            return $this->redirect(['carrinho/index']);
        }

        // Verificar se o cupão está expirado
        if (strtotime($cupao->datavalidade) < time()) {
            Yii::$app->session->setFlash('error', 'Cupão expirado.');
            return $this->redirect(['carrinho/index']);
        }

        // Verificar se o cupão está ativo
        if (!$cupao->ativo) {
            Yii::$app->session->setFlash('error', 'Cupão inativo.');
            return $this->redirect(['carrinho/index']);
        }
        // Aplicar o cupão ao carrinho
        $carrinho->cupao_id = $cupao->id;
        if ($carrinho->save()) {
            Yii::$app->session->setFlash('success', 'Cupão aplicado com sucesso!');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao aplicar o cupão. Tente novamente.');
        }
        return $this->render('index', [
            'carrinho' => $carrinho,
            'linhasCarrinho' => $carrinho->linhacarrinhos,
        ]);
    }

    public function actionRemoverCarrinho($idProduto)
    {
        // Obter o carrinho do utilizador
        $carrinho = Carrinho::findOne(['utilizadorperfil_id' => Yii::$app->user->id]);

        // Verificar se o produto existe
        $produto = Produto::findOne($idProduto);
        if (!$produto) {
            Yii::error("Produto não encontrado $idProduto", __METHOD__);
            Yii::$app->session->setFlash('error', 'Produto não encontrado');
        }

        // Verificar se o produto já está no carrinho
        $linhaCarrinho = Linhacarrinho::findOne(['carrinho_id' => $carrinho->id, 'produto_id' => $idProduto]);

        //Se estiver no carrinho, remove
        if ($linhaCarrinho) {
            if ($linhaCarrinho->delete()) {
                Yii::$app->session->setFlash('success', 'Produto removido do carrinho com sucesso!');
            } else {
                Yii::error('Erro ao remover o produto do carrinho: ' . json_encode($linhaCarrinho->errors), __METHOD__);
                Yii::$app->session->setFlash('error', 'Erro ao remover o produto do carrinho.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Produto não encontrado no carrinho.');
        }
        return $this->render('index', [
            'carrinho' => $carrinho,
            'linhasCarrinho' => $carrinho->linhacarrinhos,
        ]);
    }

    public function actionCheckout()
    {
        //Procura o carrinho do utilizador
        $carrinho = Carrinho::findOne(['utilizadorperfil_id' => Yii::$app->user->id]);

        //Verifica se o carrinho existe
        if (!$carrinho) {
            Yii::$app->session->setFlash('error', 'Carrinho não encontrado.');
            return $this->redirect(['carrinho/index']);
        }
        //Verifica se o carrinho tem produtos
        if (count($carrinho->linhacarrinhos) == 0) {
            Yii::$app->session->setFlash('error', 'Carrinho vazio.');
            return $this->redirect(['carrinho/index']);
        }

        //Verifica se o carrinho tem um cupão
        $cupao = $carrinho->cupao;
        $desconto = $cupao ? $cupao->desconto : 0;
        //Vai buscar as linhas carrinho
        // Vai buscar as linhas carrinho
        $linhasCarrinho = $carrinho->linhacarrinhos;

        // Calcula o subtotal
        $subtotal = 0;
        foreach ($linhasCarrinho as $linha) {
            $subtotal += $linha->produto->preco * $linha->quantidade;
        }

        // Calcula o valor total com desconto
        $totalComDesconto = $subtotal - $desconto;

        // Calcula o IVA
        $totalIVA = 0;
        foreach ($linhasCarrinho as $linha) {
            $totalIVA += ($linha->produto->preco * $linha->produto->iva->percentagem / 100) * $linha->quantidade;
        }






    }


}
