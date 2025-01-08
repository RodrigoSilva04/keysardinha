<?php

namespace backend\controllers;

use backend\models\UserCreateForm;
use Yii;
use common\models\User;
use common\models\UtilizadorPerfil;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->orderBy(['id' => SORT_DESC]), // Apenas busca os usuários, sem o JOIN
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single User model.
     * @param int $id
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new UserCreateForm();

        if ($model->load(Yii::$app->request->post()) && $model->createUser()) {
            Yii::$app->session->setFlash('success', 'Usuário criado com sucesso.');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $userModel = $this->findModel($id);
        $perfilModel = UtilizadorPerfil::findOne($id);  // Buscar o perfil existente

        if ($this->request->isPost && $userModel->load($this->request->post())) {

            // Verificar se o campo de password não está vazio e, se sim, atualiza-a
            if (!empty($userModel->password)) {
                $userModel->setPassword($userModel->password);  // Definir a nova senha
            }

            if ($userModel->save()){
                // Atualizar o perfil
                $perfilModel->load($this->request->post());
                $perfilModel->save();
            }

            // Atribuir a nova role (caso tenha sido alterada)
            $auth = Yii::$app->authManager;
            $role = $this->request->post('User')['role'];  // Acessar a role corretamente
            //Yii::debug('Received role: ' . $role);  // Exibir o valor recebido

            if ($role) {
                // Procurar pela role no sistema de RBAC
                $roleToAssign = $auth->getRole($role);
                if ($roleToAssign) {
                    //Yii::debug('Assigning role: ' . $role);  // Exibir a role que será atribuída

                    // Revogar todas as roles anteriores
                    $auth->revokeAll($userModel->id);

                    // Atribuir a nova role ao usuário
                    $auth->assign($roleToAssign, $userModel->id);
                } else {
                    Yii::error('Role not found: ' . $role);  // Role não encontrada
                }
            }

            // Verificar as roles atribuídas após a operação
          //  $assignedRoles = $auth->getAssignments($userModel->id);
            // Yii::debug('Assigned roles after: ' . json_encode($assignedRoles));  // Exibir as roles atribuídas

            return $this->redirect(['view', 'id' => $userModel->id]);
        }

        return $this->render('update', [
            'userModel' => $userModel,
            'perfilModel' => $perfilModel,
        ]);
    }




    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $perfilModel = UtilizadorPerfil::findOne($id);
        $perfilModel->delete();  // Deletar o perfil

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
