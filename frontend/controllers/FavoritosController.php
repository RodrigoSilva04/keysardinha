<?php

namespace frontend\controllers;

use common\models\Favoritos;
use common\models\Utilizadorperfil;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FavoritosController implements the CRUD actions for Favoritos model.
 */
class FavoritosController extends Controller
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
                    'only' => ['checkout', 'finalizarcompra', 'verificar-cupao', 'remover-carrinho'], // Ações protegidas
                    'rules' => [
                        // Regra para utilizadores autenticados
                        [
                            'allow' => true,
                            'actions' => ['create','update' ,'delete'], // Ações restritas
                            'roles' => ['@'], // Apenas para utilizadores autenticados
                        ],
                        // Regra para utilizadores não autenticados
                        [
                            'allow' => false, // Bloquear não autenticados

                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'], // Apenas POST permitido para 'delete'
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Favoritos models.
     *
     * @return string
     */
    public function actionIndex()
    {
        //ir buscar o id do user autenticado
        $idUser = Yii::$app->user->id;

        $user = Utilizadorperfil::findOne($idUser);

        $dataProvider = new ActiveDataProvider([
            'query' => $user->getFavoritos(),
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
        ]);
    }

    /**
     * Displays a single Favoritos model.
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
     * Creates a new Favoritos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($idProduto)
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/login']);
        }

        $model = new Favoritos();

        $model->utilizadorperfil_id = Yii::$app->user->id;
        $model->produto_id = $idProduto;
        if(!$model::isFavorito($model)){
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }else{
            return $this->redirect(['produto/index']);
        }

    }

    /**
     * Updates an existing Favoritos model.
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
     * Deletes an existing Favoritos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($produto_id)
    {
        $produtofavorito = Favoritos::find()
            ->where(['utilizadorperfil_id' => Yii::$app->user->id, 'produto_id' => $produto_id])
            ->one();

        if($produtofavorito){
            $produtofavorito->delete();
            Yii::$app->session->setFlash('success', 'Produto removido dos favoritos');
        }else{
            Yii::$app->session->setFlash('error', 'Produto não encontrado nos favoritos');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Favoritos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Favoritos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Favoritos::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
