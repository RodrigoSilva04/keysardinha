<?php

namespace backend\modules\api\controllers;

<<<<<<< Updated upstream
use backend\modules\api\components\CustomAuth;
use yii\filters\auth\QueryParamAuth;
=======
use common\models\Favoritos;
use common\models\Utilizadorperfil;
use Yii;
>>>>>>> Stashed changes
use yii\rest\ActiveController;

class FavoritosController extends ActiveController
{

<<<<<<< Updated upstream
    public function behaviors()
=======
    public $modelClass = 'common\models\Favoritos';

    public function actionIndex()
    {
        // Obter o ID do utilizador autenticado
        $idUser = Yii::$app->user->id;

        // Verificar se o utilizador está autenticado
        if (!$idUser) {
            return Yii::$app->response->setStatusCode(401) // Não autorizado
            ->data = [
                'status' => 'error',
                'message' => 'Usuário não autenticado.',
            ];
        }

        // Obter o perfil do utilizador
        $user = UtilizadorPerfil::findOne($idUser);

        // Verificar se o perfil do utilizador foi encontrado
        if (!$user) {
            return Yii::$app->response->setStatusCode(404) // Não encontrado
            ->data = [
                'status' => 'error',
                'message' => 'Perfil do usuário não encontrado.',
            ];
        }

        // Obter os favoritos do utilizador
        $favoritos = $user->getFavoritos()->all();

        // Retornar os favoritos em resposta
        return Yii::$app->response->setStatusCode(200) // OK
        ->data = [
            'status' => 'success',
            'message' => 'Favoritos recuperados com sucesso.',
            'data' => $favoritos,
        ];
    }

    // adicionar produto aos favoritos
    public function actionAdd($produto_id)
>>>>>>> Stashed changes
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
            //only=> ['index'], //Apenas para o GET
        ];
        return $behaviors;
    }
    // Adicionar produto aos favoritos
    public function actionAdd()
    {
        // Implementação para adicionar aos favoritos
    }

    // Remover produto dos favoritos
    public function actionRemove($id)
    {
        // Implementação para remover dos favoritos
    }

    // Sincronizar favoritos offline
    public function actionOffline()
    {
        // Implementação para sincronizar favoritos offline com o servidor
    }
}
