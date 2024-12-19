<?php

namespace backend\controllers;

use common\models\Desconto;
use common\models\Iva;
use common\models\Produto;
use common\models\Categoria;
use backend\models\UploadForm;

use yii\web\UploadedFile;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProdutoController implements the CRUD actions for Produto model.
 */
class ProdutoController extends Controller
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
     * Lists all Produto models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $categorias = Categoria::find()->all();
        $ivas = Iva::find()->all();
        $descontos = Desconto::find()->all();
        $dataProvider = new ActiveDataProvider([
            'query' => Produto::find(),

            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],

        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'categorias' => $categorias,
            'ivas' => $ivas,
            'descontos' => $descontos,
        ]);
    }

    /**
     * Displays a single Produto model.
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
     * Creates a new Produto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */

    public function actionCreate()
    {
        $model = new Produto();
        $categorias = Categoria::find()->all();
        $ivas = Iva::find()->all();
        $descontos = Desconto::find()->all();

        if ($this->request->isPost) {
            // Load data from POST request
            if ($model->load($this->request->post())) {
                // Get the uploaded image instance
                $model->imagemFile = UploadedFile::getInstance($model, 'imagemFile');  // Alterado para 'imagemFile'

                if ($model->imagemFile) {
                    // Perform the upload process
                    if ($model->uploadImagem() && $model->save()) {
                        Yii::$app->session->setFlash('success', 'Produto criado com sucesso!');
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        Yii::$app->session->setFlash('error', 'Erro ao fazer upload da imagem. Por favor, tente novamente.');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Nenhum arquivo de imagem foi recebido.');
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'categorias' => $categorias,
            'ivas' => $ivas,
            'descontos' => $descontos,
        ]);
    }




    /**
     * Updates an existing Produto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $categorias = Categoria::find()->all();
        $ivas = Iva::find()->all();
        $descontos = Desconto::find()->all();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $novaImagem = UploadedFile::getInstance($model, 'uploadImagem');

                // Verifica se há nova imagem
                if ($novaImagem) {
                    $model->uploadImagem = $novaImagem;

                    // Faz o upload da nova imagem e salva o modelo
                    if ($model->upload()) {
                        // Opcional: Remova a imagem antiga do diretório se necessário
                    }
                }

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Produto atualizado com sucesso!');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao atualizar o produto.');
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'categorias' => $categorias,
            'ivas' => $ivas,
            'descontos' => $descontos,
        ]);
    }

    /**
     * Deletes an existing Produto model.
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
     * Finds the Produto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Produto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Produto::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
