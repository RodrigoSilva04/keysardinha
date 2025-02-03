<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;

class MatematicaController extends ActiveController
{
    public $modelClass = 'common\models\Cupao';


    public function actionRaizdois(){

        $raizdois = 1.41;
        

        return Yii::$app->response->setStatusCode(200)->data = [
            'raizdois' => $raizdois,
        ];
    }

}