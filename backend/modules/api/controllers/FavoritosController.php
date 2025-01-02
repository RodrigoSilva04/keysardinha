<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class FavoritosController extends ActiveController
{
    public $modelClass = 'common\models\Favoritos';
    public function behaviors()
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
