<?php

namespace frontend\controllers;

use common\models\Comentario;
use Yii;

class ComentarioController extends \yii\web\Controller
{
    public function actionCreate()
    {
        $comentario = new Comentario();

        // Carrega os dados do formulário no modelo
        if ($comentario->load(Yii::$app->request->post())) {
            // Definir os campos antes de salvar
            $comentario->datacriacao = date('Y-m-d H:i:s'); // Define a data de criação
            $comentario->utilizadorperfil_id = Yii::$app->user->id; // Define o usuário atual
            $comentario->descricao = Yii::$app->request->post('Comentario')['descricao']; // A mensagem do comentário
            $comentario->avaliacao = Yii::$app->request->post('Comentario')['avaliacao']; // A avaliação de 1 a 5

            // Certificar-se de que o produto_id está sendo passado corretamente
            if (isset($_POST['produto_id'])) {
                $comentario->produto_id = $_POST['produto_id']; // Definir o produto relacionado
            } else {
                Yii::$app->session->setFlash('error', 'Produto não especificado.');
                return $this->redirect(['produto/index']); // Redireciona para a página de produtos
            }

            // Salva o comentário
            if ($comentario->save()) {
                Yii::$app->session->setFlash('success', 'Comentário adicionado com sucesso.');
                return $this->redirect(['produto/view', 'id' => $comentario->produto_id]); // Redireciona para a visualização do produto
            } else {
                // Caso o comentário não seja salvo
                Yii::$app->session->setFlash('error', 'Ocorreu um erro ao salvar o comentário. Tente novamente.');
            }
        }

        // Redireciona de volta caso não consiga salvar ou se os dados estiverem incompletos
        return $this->redirect(['produto/view', 'id' => $comentario->produto_id]);
    }



}
