<?php

namespace backend\modules\api\controllers;

use backend\modules\api\components\CustomAuth;
use common\models\Fatura;
use common\models\Linhacarrinho;
use common\models\Linhafatura;
use Yii;
use yii\rest\ActiveController;

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
    public function actionFindFatura()
    {
        // Obtém o ID do utilizador logado
        $idUser = Yii::$app->user->id;

        // Verifica se o utilizador está autenticado
        if (!$idUser) {
            Yii::$app->response->statusCode = 401; // Não autorizado
            return [
                'status' => 'error',
                'message' => 'Utilizador não autenticado.',
            ];
        }
        $faturas = Fatura::find()->where(['utilizadorperfil_id' => $idUser])->all();

        // Verifica se existem faturas para o utilizador
        if (empty($faturas)) {
            Yii::$app->response->statusCode = 404; // Não encontrado
            return [
                'status' => 'error',
                'message' => 'Nenhuma fatura encontrada para este utilizador.',
            ];
        }

        // Retorna as faturas do utilizador autenticado
        Yii::$app->response->statusCode = 200; // OK
        return [
            'status' => 'success',
            'message' => 'Faturas recuperadas com sucesso.',
            'data' => $faturas,
        ];
    }

    public function actionView()
    {
        // Obtem a fatura pelo ID através dos parâmetros da URL
        $id = Yii::$app->request->get('id');

        // Verifica se a fatura existe
        $fatura = Fatura::findOne($id); // Busca a fatura pelo ID

        if (!$fatura) {
            Yii::$app->response->statusCode = 404;
            return [
                'status' => 'error',
                'message' => 'Fatura não encontrada.',
            ];
        }

        // Busca as linhas da fatura associadas
        $linhasFatura = Linhafatura::find()
            ->where(['fatura_id' => $id])
            ->all();

        // Retorna os detalhes da fatura e suas linhas
        Yii::$app->response->statusCode = 200;
        return [
            'status' => 'success',
            'message' => 'Fatura encontrada com sucesso.',
            'fatura' => $fatura,
            'linhasFatura' => $linhasFatura,
        ];
    }
    public function actionDetalhes($id)
{
    // Verifica se a fatura existe
    $fatura = Fatura::findOne($id); // Busca a fatura pelo ID

    if (!$fatura) {
        Yii::$app->response->statusCode = 404;
        return [
            'status' => 'error',
            'message' => 'Fatura não encontrada.',
        ];
    }

    // Busca as linhas da fatura associadas
    $linhasFatura = Linhafatura::find()
        ->where(['fatura_id' => $id])
        ->all();

    // Prepara o array de dados das linhas
    $linhasDetalhes = [];
    foreach ($linhasFatura as $linha) {
    
        $linhasDetalhes[] = [
            'id' => $linha->id,
            'quantidade' => $linha->quantidade,
            'precounitario' => number_format($linha->precounitario, 2, '.', ''),
            'subtotal' => number_format($linha->subtotal, 2, '.', ''),
            'fatura_id' => $linha->fatura_id,
            'desconto' => $linha->produto->desconto->percentagem, // Supondo que desconto seja um valor percentual
            'produto' => $linha->produto->nome,
            'iva' => $linha->produto->iva ? "{$linha->produto->iva->taxa}%" : null, // Assumindo que a relação IVA existe
            'chavedigital' => $linha->chavedigital ? $linha->chavedigital->chaveativacao : null, // Chave de ativação do produto
        ];
    }

    // Retorna os detalhes da fatura e suas linhas
    Yii::$app->response->statusCode = 200;
    return [
        'status' => 'success',
        'message' => 'Fatura encontrada com sucesso.',
        'fatura' => [
            'id' => $fatura->id,
            'datafatura' => $fatura->datafatura, // A data deve estar no formato de string já
            'totalciva' => number_format($fatura->totalciva, 2, '.', ''),
            'subtotal' => number_format($fatura->subtotal, 2, '.', ''),
            'valor_total' => number_format($fatura->valor_total, 2, '.', ''),
            'estado' => $fatura->estado,
            'descontovalor' => number_format($fatura->descontovalor, 2, '.', ''),
            'datapagamento' => $fatura->datapagamento,
            'utilizadorperfil_id' => $fatura->utilizadorperfil_id,
            'metodopagamento' => $fatura->metodopagamento->nomemetodopagamento,
            'desconto_id' => $fatura->desconto_id,
            'cupao_id' => $fatura->cupao_id,
        ],
        'linhasFatura' => $linhasDetalhes,
    ];
}





}
