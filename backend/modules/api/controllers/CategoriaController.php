<?php

namespace app\modules\api\controllers;

use common\models\Categoria;
use Yii;

class CategoriaController extends \yii\web\Controller
{
    public function actionIndex()
    {
        // Obter todas as categorias
        $categorias = Categoria::find()->all();

        // Verificar se existem categorias
        if ($categorias) {
            // Retornar resposta com status 200 e os dados das categorias
            return Yii::$app->response->setStatusCode(200)
                ->data = [
                'status' => 'success',
                'message' => 'Categorias recuperadas com sucesso.',
                'data' => $categorias,
            ];
        } else {
            // Retornar resposta com status 404 se não encontrar categorias
            return Yii::$app->response->setStatusCode(404)
                ->data = [
                'status' => 'error',
                'message' => 'Nenhuma categoria encontrada.',
            ];
        }
    }

    // Ação para visualizar uma categoria específica
    public function actionView($id)
    {
        // Procurar a categoria pelo ID
        $categoria = Categoria::findOne($id);

        // Verificar se a categoria existe
        if (!$categoria) {
            // Retornar resposta com código 404 se não encontrar a categoria
            return Yii::$app->response->setStatusCode(404)
                ->data = [
                'status' => 'error',
                'message' => 'Categoria não encontrada.',
            ];
        }

        // Retornar resposta com a categoria encontrada
        return Yii::$app->response->setStatusCode(200)
            ->data = [
            'status' => 'success',
            'message' => 'Categoria encontrada com sucesso.',
            'categoria' => $categoria,
        ];
    }

    public function actionCreate()
    {
        $model = new Categoria();

        // Verifica se a requisição é do tipo POST
        if (Yii::$app->request->isPost) {
            // Carrega os dados do formulário e valida
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return Yii::$app->response->setStatusCode(201) // Status de criação
                ->data = [
                    'status' => 'success',
                    'message' => 'Categoria criada com sucesso.',
                    'data' => $model,
                ];
            } else {
                // Caso haja erro ao salvar, retorna os erros
                return Yii::$app->response->setStatusCode(400) // Bad request
                ->data = [
                    'status' => 'error',
                    'message' => 'Erro ao criar a categoria.',
                    'errors' => $model->errors,
                ];
            }
        }

        // Caso a requisição não seja POST, retorna um erro
        return Yii::$app->response->setStatusCode(400)
            ->data = [
            'status' => 'error',
            'message' => 'Requisição inválida.',
        ];
    }

    public function actionUpdate($id)
    {
        // Procurar a categoria pelo ID
        $model = Categoria::findOne($id);

        // Verificar se a categoria existe
        if (!$model) {
            return Yii::$app->response->setStatusCode(404) // Não encontrado
            ->data = [
                'status' => 'error',
                'message' => 'Categoria não encontrada.',
            ];
        }

        // Verifica se a requisição é do tipo POST
        if (Yii::$app->request->isPost) {
            // Carrega os dados do formulário e valida
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return Yii::$app->response->setStatusCode(200) // OK
                ->data = [
                    'status' => 'success',
                    'message' => 'Categoria atualizada com sucesso.',
                    'data' => $model,
                ];
            } else {
                // Caso haja erro ao salvar, retorna os erros
                return Yii::$app->response->setStatusCode(400) // Bad request
                ->data = [
                    'status' => 'error',
                    'message' => 'Erro ao atualizar a categoria.',
                    'errors' => $model->errors,
                ];
            }
        }

        return Yii::$app->response->setStatusCode(400)
            ->data = [
            'status' => 'error',
            'message' => 'Requisição inválida.',
        ];
    }

    public function actionDelete($id)
    {
        // Procurar a categoria pelo ID
        $model = Categoria::findOne($id);

        // Verificar se a categoria existe
        if (!$model) {
            return Yii::$app->response->setStatusCode(404) // Não encontrado
            ->data = [
                'status' => 'error',
                'message' => 'Categoria não encontrada.',
            ];
        }

        // Deletar a categoria
        if ($model->delete()) {
            return Yii::$app->response->setStatusCode(200) // OK
            ->data = [
                'status' => 'success',
                'message' => 'Categoria deletada com sucesso.',
            ];
        } else {
            return Yii::$app->response->setStatusCode(400) // Bad request
            ->data = [
                'status' => 'error',
                'message' => 'Erro ao deletar a categoria.',
            ];
        }
    }
}
