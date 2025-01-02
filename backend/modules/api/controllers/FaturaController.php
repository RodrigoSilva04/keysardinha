<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use yii\rest\ActiveController;
use yii\rest\Controller;
class FaturaController extends ActiveController
{
    public $modelClass = 'common\models\Fatura';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),

        ];
        return $behaviors;
    }


}