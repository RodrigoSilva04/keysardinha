<?php

namespace frontend\controllers;

use common\models\Produto; // Certifique-se de que o caminho está correto
use yii\data\ActiveDataProvider;

class ProdutoController extends \yii\web\Controller
{
    public function actionIndex()
    {
        // Criando o ActiveDataProvider
        $dataProvider = new ActiveDataProvider([
            'query' => Produto::find(), // Substitua 'Produto' pelo nome correto do seu modelo
        ]);

        // Renderizando a view e passando o dataProvider
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
