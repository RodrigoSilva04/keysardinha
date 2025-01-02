<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Cupao;
use Yii;
use yii\rest\ActiveController;

class CupaoController extends ActiveController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $modelClass = 'common\models\Cupao';

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
        $cupao = new Cupao();

        // Carregar dados da requisição POST
        if ($cupao->load(Yii::$app->request->post(), '') && $cupao->save()) {
            return Yii::$app->response->setStatusCode(200)->data = [
                'status' => 'success',
                'message' => 'Cupão criado com sucesso.',
            ];
        } else {
            return Yii::$app->response->setStatusCode(400)->data = [
                'status' => 'error',
                'message' => 'Erro ao criar o cupão.',
            ];
        }
    }

}