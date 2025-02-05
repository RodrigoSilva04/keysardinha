<?php

namespace frontend\controllers;

use common\models\Cupao;
use common\models\Utilizadorperfil;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class CupaoController extends \yii\web\Controller
{

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['index', 'trocar'], // Ações protegidas
                    'rules' => [
                        // Regra para utilizadores autenticados
                        [
                            'allow' => true,
                            'actions' => ['index', 'trocar'], // Ações restritas
                            'roles' => ['@'], // Apenas para utilizadores autenticados
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'], // Apenas POST permitido para 'delete'
                    ],
                ],
            ]
        );
    }
    public function actionIndex()
    {
        $utilizadorperfil = Utilizadorperfil::find()->where(['id' => Yii::$app->user->id])->one();

        $pontos = $utilizadorperfil->pontosacumulados;

        // Renderiza a view passando as faturas
        return $this->render('index',[
            'pontos' => $pontos
            ]
        );
    }

    public function actionTrocar()
    {
        // Obter o utilizador logado
        $user = Utilizadorperfil::find()->where(['id' => Yii::$app->user->id])->one();

        // Obter os valores enviados pelo formulário
        $valor = Yii::$app->request->post('valor');
        $pontosNecessarios = Yii::$app->request->post('pontosnecessarios');

        // Obter os pontos do utilizador
        $pontos = $user->pontosacumulados;

        // Verificar se o utilizador tem pontos suficientes
        if ($pontos >= $pontosNecessarios) {
            // Subtrair os pontos usados
            $user->pontosacumulados -= $pontosNecessarios;

            // Criar o cupão
            $cupao = new Cupao();
            $cupao->valor = $valor;
            $cupao->datavalidade = date('Y-m-d', strtotime('+1 year')); // Exemplo de validade
            $cupao->ativo = 1;
            $cupao->codigo = $this->gerarRandomCodigoCupao();
            $cupao->save();

            // Salvar as alterações no perfil do utilizador
            $user->save();

            // Definir uma mensagem de sucesso
            Yii::$app->session->setFlash('success', 'Cupão trocado com sucesso! Verifique a sua lista de cupões.');
        } else {
            // Caso o utilizador não tenha pontos suficientes
            Yii::$app->session->setFlash('error', 'Você não tem pontos suficientes para resgatar este cupão.');
        }

        // Redirecionar de volta à página de cupons
        return $this->redirect(['cupao/index']);
    }

    public function gerarRandomCodigoCupao()
    {
        // Definir os caracteres que serão usados no código do cupão
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        // Definir o comprimento do código (ex: 10 caracteres)
        $comprimento = 10;

        // Gerar o código aleatório
        $codigoCupao = '';
        for ($i = 0; $i < $comprimento; $i++) {
            $codigoCupao .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        // Verificar se o código gerado já existe no banco (evitar duplicados)
        while (Cupao::find()->where(['codigo' => $codigoCupao])->exists()) {
            // Se o código já existe, gerar um novo
            $codigoCupao = '';
            for ($i = 0; $i < $comprimento; $i++) {
                $codigoCupao .= $caracteres[rand(0, strlen($caracteres) - 1)];
            }
        }

        return $codigoCupao;
    }




}
