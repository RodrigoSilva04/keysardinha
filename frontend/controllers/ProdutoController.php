<?php

namespace frontend\controllers;

use common\models\Produto; // Certifique-se de que o caminho está correto
use yii\data\ActiveDataProvider;

class ProdutoController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout = 'main';
        $produtos = Produto::find()->with('categoria')->all();
        return $this->render('index', [
            'produtos' => $produtos,
        ]);

    }
}
