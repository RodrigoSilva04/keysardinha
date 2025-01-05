<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Metodopagamento;
use yii\rest\ActiveController;

class MetodopagamentoController extends ActiveController
{
    public $modelClass = 'common\models\Metodopagamento';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
            //only=> ['index'], //Apenas para o GET
        ];
        return $behaviors;
    }

    public function actionCreate()
    {
        $model = new MetodoPagamento();
        $data = \Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return [
                'status' => 'success',
                'message' => 'Método de pagamento criado com sucesso.',
                'data' => $model,
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Falha ao criar o método de pagamento.',
            'errors' => $model->errors,
        ];
    }

    public function actionUpdate($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $metodoPagamento = MetodoPagamento::findOne($id);
        if (!$metodoPagamento) {
            return [
                'status' => 'error',
                'message' => 'Método de pagamento não encontrado.',
            ];
        }
        $metodoPagamento->load(\Yii::$app->request->post(), '');

        if ($metodoPagamento->save()) {
            return [
                'status' => 'success',
                'message' => 'Método de pagamento atualizado com sucesso.',
                'data' => $metodoPagamento->attributes,
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Erro ao atualizar o método de pagamento.',
            'errors' => $metodoPagamento->errors,
        ];
    }

    public function actionDelete($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = MetodoPagamento::findOne($id);
        if (!$model) {
            \Yii::$app->response->setStatusCode(404);
            return [
                'status' => 'error',
                'message' => 'Método de pagamento não encontrado.',
            ];
        }

        if ($model->delete()) {
            return [
                'status' => 'success',
                'message' => 'Método de pagamento deletado com sucesso.',
            ];
        }

        \Yii::$app->response->setStatusCode(500);
        return [
            'status' => 'error',
            'message' => 'Erro ao deletar o método de pagamento.',
        ];
    }


}

