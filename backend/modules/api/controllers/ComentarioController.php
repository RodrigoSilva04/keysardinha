<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Comentario;
use Yii;
use yii\rest\ActiveController;

class ComentarioController extends ActiveController
{
    public $modelClass = 'common\models\Comentario';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }

    public function actionCreate()
    {
        $comentario = new Comentario();

        // Carregar dados da requisição POST
        if ($comentario->load(Yii::$app->request->post(), '') && $comentario->save()) {
            return Yii::$app->response->setStatusCode(200)->data = [
                'status' => 'success',
                'message' => 'Comentario criado com sucesso.',
            ];
        } else {
            return Yii::$app->response->setStatusCode(400)->data = [
                'status' => 'error',
                'message' => 'Erro ao criar o comentario.',
            ];
        }
    }
}