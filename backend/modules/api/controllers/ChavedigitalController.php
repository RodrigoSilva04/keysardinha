<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Chavedigital;
use common\models\Produto;
use Yii;
use yii\rest\ActiveController;

class ChavedigitalController extends ActiveController
{
    public $modelClass = 'common\models\Chavedigital';
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
        ];
        return $behaviors;
    }
    public function actionIndex()
    {
        $chavesDigitais = Chavedigital::find()->all();
        // Verificar se existem registos
        if (!empty($chavesDigitais)) {
            // Formatar os dados das chaves digitais para retorno
            $dadosFormatados = [];
            foreach ($chavesDigitais as $chave) {
                $dadosFormatados[] = [
                    'id' => $chave->id,
                    'chaveAtivacao' => $chave->chaveativacao,
                    'estado' => $chave->estado,
                    'produtoId' => $chave->produto_id,
                    'datavenda' => $chave->datavenda,
                ];
            }

            Yii::$app->response->statusCode = 200; // Sucesso
            return [
                'status' => 'success',
                'message' => 'Chaves digitais recuperadas com sucesso.',
                'data' => $dadosFormatados,
            ];
        } else {
            Yii::$app->response->statusCode = 404; // Não encontrado
            return [
                'status' => 'error',
                'message' => 'Nenhuma chave digital encontrada.',
            ];
        }
    }

    public function actionView($id)
    {
        // Encontrar a chave digital pelo ID
        $chaveDigital = Chavedigital::findOne($id);

        if ($chaveDigital) {
            Yii::$app->response->statusCode = 200; // Sucesso
            return [
                'status' => 'success',
                'message' => 'Chave digital encontrada.',
                'data' => [
                    'id' => $chaveDigital->id,
                    'chaveAtivacao' => $chaveDigital->chaveativacao,
                    'estado' => $chaveDigital->estado,
                    'produtoId' => $chaveDigital->produto_id,
                    'datavenda' => $chaveDigital->datavenda,
                ],
            ];
        } else {
            Yii::$app->response->statusCode = 404; // Não encontrado
            return [
                'status' => 'error',
                'message' => 'Chave digital não encontrada.',
            ];
        }
    }

    public function actionCreate()
    {
        $model = new Chavedigital();

        // Verificar se os dados foram enviados em uma requisição POST
        if (Yii::$app->request->isPost) {
            // Carregar os dados no modelo e validar
            if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
                // Tentar salvar a chave digital
                if ($model->save()) {
                    // Encontra o produto associado à chave digital
                    $produto = Produto::findOne($model->produto_id);

                    if ($produto) {
                        // Incrementar o stock disponível do produto
                        $produto->stockdisponivel += 1;

                        // Tentar salvar as alterações no produto
                        if ($produto->save()) {
                            Yii::$app->response->statusCode = 201; // Código HTTP para recurso criado
                            return [
                                'status' => 'success',
                                'message' => 'Chave digital criada e stock atualizado com sucesso.',
                                'data' => [
                                    'chaveDigitalId' => $model->id,
                                    'produtoId' => $produto->id,
                                    'produtoNome' => $produto->nome,
                                    'stockAtualizado' => $produto->stockdisponivel,
                                ],
                            ];
                        } else {
                            Yii::$app->response->statusCode = 500; // Código HTTP para erro interno
                            return [
                                'status' => 'error',
                                'message' => 'Erro ao atualizar o stock do produto.',
                                'errors' => $produto->errors,
                            ];
                        }
                    } else {
                        Yii::$app->response->statusCode = 404; // Código HTTP para recurso não encontrado
                        return [
                            'status' => 'error',
                            'message' => 'Produto associado não encontrado.',
                        ];
                    }
                } else {
                    Yii::$app->response->statusCode = 500; // Código HTTP para erro interno
                    return [
                        'status' => 'error',
                        'message' => 'Erro ao guardar a chave digital.',
                        'errors' => $model->errors,
                    ];
                }
            } else {
                Yii::$app->response->statusCode = 422;
                return [
                    'status' => 'error',
                    'message' => 'Dados inválidos.',
                    'errors' => $model->errors,
                ];
            }
        }

        //Caso não seja uma requisição POST, retorna erro
        Yii::$app->response->statusCode = 405; //Código HTTP para metodo não permitido
        return [
            'status' => 'error',
            'message' => 'Método não permitido. Utilize POST para criar uma chave digital.',
        ];
    }

    public function actionUpdate($id)
    {

        //Procurar a chave digital pelo ID
        $chaveDigital = Chavedigital::findOne($id);

        if (!$chaveDigital) {
            Yii::$app->response->statusCode = 404; // Não encontrado
            return [
                'status' => 'error',
                'message' => 'Chave digital não encontrada.',
            ];
        }

        // Carregar os dados enviados no modelo e validar
        if ($chaveDigital->load(Yii::$app->request->post(), '') && $chaveDigital->validate()) {
            if ($chaveDigital->save()) {
                Yii::$app->response->statusCode = 200;// Sucesso
                return [
                    'status' => 'success',
                    'message' => 'Chave digital atualizada com sucesso.',
                    'data' => [
                        'id' => $chaveDigital->id,
                        'chaveAtivacao' => $chaveDigital->chaveativacao,
                        'estado' => $chaveDigital->estado,
                        'produtoId' => $chaveDigital->produto_id,
                        'datavenda' => $chaveDigital->datavenda,
                    ],
                ];
            } else {
                Yii::$app->response->statusCode = 500; //Erro interno
                return [
                    'status' => 'error',
                    'message' => 'Erro ao atualizar a chave digital.',
                    'errors' => $chaveDigital->errors,
                ];
            }
        } else {
            Yii::$app->response->statusCode = 422; // Dados inválidos
            return [
                'status' => 'error',
                'message' => 'Dados inválidos.',
                'errors' => $chaveDigital->errors,
            ];
        }
    }

    public function actionDelete($id)
    {
        // Procurar a chave digital pelo ID
        $chaveDigital = Chavedigital::findOne($id);

        if (!$chaveDigital) {
            Yii::$app->response->statusCode = 404; // Não encontrado
            return [
                'status' => 'error',
                'message' => 'Chave digital não encontrada.',
            ];
        }

        // Tenta apagar o registo
        if ($chaveDigital->delete()) {
            Yii::$app->response->statusCode = 200; // Sucesso
            return [
                'status' => 'success',
                'message' => 'Chave digital eliminada com sucesso.',
            ];
        } else {
            Yii::$app->response->statusCode = 500; // Erro interno
            return [
                'status' => 'error',
                'message' => 'Erro ao apagar a chave digital.',
            ];
        }
    }
}
