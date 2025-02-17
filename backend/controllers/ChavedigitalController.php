<?php

namespace backend\controllers;

use common\models\Chavedigital;
use common\models\Produto;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ChavedigitalController implements the CRUD actions for Chavedigital model.
 */
class ChavedigitalController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['index', 'view', 'create', 'update', 'delete'], // Ações protegidas
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'view', 'create', 'update', 'delete'], // Permitir acesso às ações 'index' e 'view'
                            'roles' => ['@'], // Apenas para usuários autenticados
                        ],
                        [
                            'allow' => false, // Bloquear todas as outras tentativas de acesso
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'], // Apenas POST permitido para 'delete'
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Chavedigital models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $produtos = Produto::find()->all();
        $dataProvider = new ActiveDataProvider([
            'query' => Chavedigital::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'produtos' => $produtos,
        ]);
    }

    /**
     * Displays a single Chavedigital model.
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
     * Creates a new Chavedigital model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Chavedigital();
        $produtos = Produto::find()->all();

        // Verificar se a requisição é um POST
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                // Encontra o produto associado à chave digital
                $produto = Produto::findOne($model->produto_id);

                if ($produto) {
                    // Incrementa o estoque do produto
                    $produto->stockdisponivel += 1;

                    // Salva o produto com o estoque atualizado
                    if ($produto->save()) {
                        Yii::$app->session->setFlash('success', 'Chave digital salva e stock atualizado com sucesso!');
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        Yii::$app->session->setFlash('error', 'Erro ao atualizar o stock do produto.');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Produto não encontrado.');
                }
            } else {
                // Se não conseguiu salvar o modelo de chave digital
                Yii::$app->session->setFlash('error', 'Erro ao salvar a chave digital.');
            }
        }

        // Carrega os valores padrão se não for um POST
        $model->loadDefaultValues();

        // Renderiza a view de criação
        return $this->render('create', [
            'model' => $model,
            'produtos' => $produtos,
        ]);
    }

    /**
     * Updates an existing Chavedigital model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $produtos = Produto::find()->all();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            //Se o modelo foi salvo e o campo esta nao usada
            if ($model->estado == 'usada') {
            // Encontra o produto associado à chave digital
            $produto = Produto::findOne($model->produto_id);
            // Incrementa o estoque do produto
            $produto->stockdisponivel += 1;
            // Salva o produto com o stock atualizado
            if ($produto->save()) {
                Yii::$app->session->setFlash('success', 'Chave digital atualizada e stock atualizado com sucesso!');
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao atualizar o stock do produto.');
                $this->redirect(['view', 'id' => $model->id]);
            }
            }else{
                Yii::$app->session->setFlash('error', 'Erro ao atualizar a chave digital.');
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }


        return $this->render('update', [
            'model' => $model,
            'produtos' => $produtos,
        ]);
    }

    /**
     * Deletes an existing Chavedigital model.
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

    public function actionLimparChavesUsadas()
    {
        $chavesUsadas = Chavedigital::findAll(['estado' => 'usada']);
        foreach ($chavesUsadas as $chaveUsada) {

            if ($chaveUsada->delete()) {
                Yii::$app->session->setFlash('success', 'Chaves digitais usadas eliminadas com sucesso!');
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao eliminar chaves digitais usadas.');
            }
        }
        Yii::$app->session->setFlash('success', 'Chaves digitais usadas eliminadas com sucesso!');
        return $this->redirect(['index']);
    }

    public function actionSincronizarStocks()
    {
        // Obter todas as chaves digitais
        $chavesDigitais = Chavedigital::find()->all();

        $produtos = Produto::find()->all();

        foreach ($produtos as $produto) {
            // Verifica se o produto tem chaves digitais associadas
            $chavesProduto = Chavedigital::findAll(['produto_id' => $produto->id]);

            // Se o produto não tiver chaves, o stock será 0
            if (count($chavesProduto) == 0) {
                $produto->stockdisponivel = 0;

                // Não altere o campo categoria_id
                // Apenas salvar a atualização de stock
                if (!$produto->save(false)) { // Desativa a validação para categoria_id
                    Yii::$app->session->setFlash('error', "Erro ao atualizar o stock do produto ID {$produto->id}.");
                    var_dump('erro ao atualizar');
                    var_dump($produto->errors);
                    die();
                }
            }
        }

        // Agrupar as chaves digitais por produto
        $produtoChaves = [];
        foreach ($chavesDigitais as $chaveDigital) {
            $produtoChaves[$chaveDigital->produto_id][] = $chaveDigital;
        }

        // Agora, atualizar o stock para cada produto com chaves digitais
        foreach ($produtoChaves as $produtoId => $chaves) {
            // Obter o produto correspondente
            $produto = Produto::findOne($produtoId);

            if ($produto) {
                // Contar o número de chaves para esse produto
                $numeroChaves = count($chaves);

                // Atualizar o stock do produto
                $produto->stockdisponivel = $numeroChaves;

                // Se o produto não tem chaves, o stock será 0
                if ($numeroChaves == 0) {
                    $produto->stockdisponivel = 0;
                }

                // Salvar o produto com o novo valor de stock
                if (!$produto->save(false)) { // Desativa a validação para categoria_id
                    Yii::$app->session->setFlash('error', "Erro ao atualizar o stock do produto ID {$produtoId}.");
                }
            }
        }

        // Mensagem de sucesso
        Yii::$app->session->setFlash('success', 'Stocks sincronizados com sucesso!');

        // Redireciona para a página de índice ou qualquer outra página desejada
        return $this->redirect(['index']);
    }






    /**
     * Finds the Chavedigital model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Chavedigital the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Chavedigital::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
