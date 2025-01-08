<?php

namespace frontend\controllers;

use common\models\Carrinho;
use common\models\Chavedigital;
use common\models\Cupao;
use common\models\Desconto;
use common\models\Fatura;
use common\models\Linhacarrinho;
use common\models\Linhafatura;
use common\models\Metodopagamento;
use common\models\Produto;
use common\models\Utilizadorperfil;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\conditions\ExistsConditionBuilder;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CarrinhoController implements the CRUD actions for Carrinho model.
 */
class CarrinhoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['checkout', 'finalizarcompra', 'verificar-cupao', 'remover-carrinho'], // Ações protegidas
                    'rules' => [
                        // Regra para utilizadores autenticados
                        [
                            'allow' => true,
                            'actions' => ['checkout', 'finalizarcompra'], // Ações restritas
                            'roles' => ['@'], // Apenas para utilizadores autenticados
                        ],
                        // Regra para utilizadores não autenticados
                        [
                            'allow' => false, // Bloquear não autenticados
                            'actions' => ['checkout', 'finalizarcompra'], // Bloqueia o acesso a essas ações
                            'roles' => ['?'], // Aplicado para não autenticados
                        ],
                        // Regras adicionais para ações específicas que podem ser acessadas por todos
                        [
                            'allow' => true,
                            'actions' => ['verificar-cupao', 'remover-carrinho'], // Estas ações podem ser acessadas por todos
                            'roles' => ['@', '?'], // Tanto autenticados como não autenticados
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


    /**
     * Lists all Carrinho models.
     *
     * @return string
     */
    public function actionIndex()
    {
        //Obter o carrinho do utilizador
        $carrinho = Carrinho::findone(['utilizadorperfil_id' => Yii::$app->user->id]);

        //Verifica se o utilizador tem algum produto no carrinho
        if (!$carrinho) {
            // Criar carrinho caso não exista
            $carrinho = new Carrinho();
            $carrinho->utilizadorperfil_id = Yii::$app->user->id;
            $carrinho->data_criacao = date('Y-m-d H:i:s');
            if (!$carrinho->save()) {
                $erros = json_encode($carrinho->errors);
                Yii::error("Erro ao criar carrinho: $erros", __METHOD__);
                Yii::$app->session->setFlash('error', "Erro ao criar o carrinho: $erros");
                return $this->redirect(['produto/index']);
            }
        }




        //Buscar as linhas do carrinho associado
        $linhasCarrinho = Linhacarrinho::find()->where(['carrinho_id' => $carrinho->id])->all();

        return $this->render('index', [
            'carrinho' => $carrinho,
            'linhasCarrinho' => $linhasCarrinho,
        ]);
    }

    /**
     * Displays a single Carrinho model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Carrinho model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Carrinho();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Carrinho model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Carrinho model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Carrinho model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Carrinho the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Carrinho::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAddToCart($IdProduto)
    {
        // Obter o carrinho do utilizador
        $carrinho = Carrinho::findOne(['utilizadorperfil_id' => Yii::$app->user->id]);

        // Se não tiver carrinho, cria um
        if (!$carrinho){
            $carrinho = new Carrinho();
            $carrinho->utilizadorperfil_id = Yii::$app->user->id;
            if (!$carrinho->save()) {
                Yii::error('Erro ao criar o carrinho para o usuário ID: ' . Yii::$app->user->id . '. Erros: ' . json_encode($carrinho->errors), __METHOD__);
                Yii::$app->session->setFlash('error', 'Erro ao criar o carrinho.');

            }
        }

        // Verificar se o produto existe
        $produto = Produto::findOne($IdProduto);

        if (!$produto) {
            Yii::error("Produto não encontrado com ID: $IdProduto", __METHOD__);
            Yii::$app->session->setFlash('error', 'Produto não encontrado');

        }

        // Verificar se o produto já está no carrinho
        $linhaCarrinho = Linhacarrinho::findOne(['carrinho_id' => $carrinho->id, 'produto_id' => $IdProduto]);

        if ($linhaCarrinho) {
            $linhaCarrinho->quantidade += 1;
            if (!$linhaCarrinho->save()) {
                Yii::error('Erro ao atualizar a linha do carrinho: ' . json_encode($linhaCarrinho->errors), __METHOD__);
                Yii::$app->session->setFlash('error', 'Erro ao atualizar o produto no carrinho.');

            }
        } else {
            // Se não estiver, cria uma nova linha no carrinho
            $linhaCarrinho = new Linhacarrinho();
            $linhaCarrinho->carrinho_id = $carrinho->id;
            $linhaCarrinho->produto_id = $IdProduto;
            $linhaCarrinho->quantidade = 1;
            //Verifica se o produto tem desconto
            $desconto = $produto->desconto;

            // Verifique se o produto tem desconto
            if ($desconto) {
                // Calcule o preço unitário com o desconto
                $precounitario = $produto->preco - ($produto->preco * $desconto->percentagem / 100);
            } else {
                // Se não houver desconto, o preço unitário será o preço original
                $precounitario = $produto->preco;
            }

            // Atribua o preço unitário ao item do carrinho
            $linhaCarrinho->preco_unitario = $precounitario;;

            if (!$linhaCarrinho->save()) {
                Yii::error('Erro ao criar a linha do carrinho: ' . json_encode($linhaCarrinho->errors), __METHOD__);
                Yii::$app->session->setFlash('error', 'Erro ao adicionar o produto ao carrinho.');

            }
        }

        Yii::$app->session->setFlash('success', 'Produto adicionado ao carrinho com sucesso!');
        return $this->redirect(['carrinho/index']);
    }


    public function actionVerificarCupao()
    {
        //Vai buscar o cupão
        if (yii::$app->request->isPost){
        $codigoCupao = Yii::$app->request->post('codigo');
        }

        // Obter o carrinho do utilizador
        $carrinho = Carrinho::findOne(['utilizadorperfil_id' => Yii::$app->user->id]);


        if (!$carrinho) {
            Yii::$app->session->setFlash('error', 'Carrinho não encontrado.');
            return $this->redirect(['carrinho/index']);
        }
        //Pelo codigo do cupão, vai buscar o cupão
        $cupao = Cupao::findOne(['codigo' => $codigoCupao]);

        //Se o cupão não existir, retorna uma mensagem de erro
        if (!$cupao) {
            Yii::$app->session->setFlash('error', 'Cupão não encontrado.');
            return $this->redirect(['carrinho/index']);
        }

        // Verificar se o cupão está expirado
        if (strtotime($cupao->datavalidade) < time()) {
            Yii::$app->session->setFlash('error', 'Cupão expirado.');
            return $this->redirect(['carrinho/index']);
        }

        // Verificar se o cupão está ativo
        if (!$cupao->ativo) {
            Yii::$app->session->setFlash('error', 'Cupão inativo.');
            return $this->redirect(['carrinho/index']);
        }
        // Aplicar o cupão ao carrinho
        $carrinho->cupao_id = $cupao->id;
        if ($carrinho->save()) {
            Yii::$app->session->setFlash('success', 'Cupão aplicado com sucesso!');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao aplicar o cupão. Tente novamente.');
        }
        return $this->render('index', [
            'carrinho' => $carrinho,
            'linhasCarrinho' => $carrinho->linhacarrinhos,
        ]);
    }

    public function actionRemoverCarrinho($idProduto)
    {
        // Obter o carrinho do utilizador
        $carrinho = Carrinho::findOne(['utilizadorperfil_id' => Yii::$app->user->id]);

        // Verificar se o produto existe
        $produto = Produto::findOne($idProduto);
        if (!$produto) {
            Yii::error("Produto não encontrado $idProduto", __METHOD__);
            Yii::$app->session->setFlash('error', 'Produto não encontrado');
        }

        // Verificar se o produto já está no carrinho
        $linhaCarrinho = Linhacarrinho::findOne(['carrinho_id' => $carrinho->id, 'produto_id' => $idProduto]);

        //Se estiver no carrinho, remove
        if ($linhaCarrinho) {
            if ($linhaCarrinho->delete()) {
                Yii::$app->session->setFlash('success', 'Produto removido do carrinho com sucesso!');
            } else {
                Yii::error('Erro ao remover o produto do carrinho: ' . json_encode($linhaCarrinho->errors), __METHOD__);
                Yii::$app->session->setFlash('error', 'Erro ao remover o produto do carrinho.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Produto não encontrado no carrinho.');
        }
        return $this->render('index', [
            'carrinho' => $carrinho,
            'linhasCarrinho' => $carrinho->linhacarrinhos,
        ]);
    }

    public function actionCheckout()
    {
        //Vai buscar os métodos de pagamento
        $metodospagamento = Metodopagamento::find()->all();

        //Procura o carrinho do utilizador
        $carrinho = Carrinho::findOne(['utilizadorperfil_id' => Yii::$app->user->id]);

        //Verifica se o carrinho existe
        if (!$carrinho) {
            Yii::$app->session->setFlash('error', 'Carrinho não encontrado.');
            return $this->redirect(['carrinho/index']);
        }
        //Verifica se o carrinho tem produtos
        if (count($carrinho->linhacarrinhos) == 0) {
            Yii::$app->session->setFlash('error', 'Carrinho vazio.');
            return $this->redirect(['carrinho/index']);
        }

        //Verifica se o carrinho tem um cupão
        $cupao = $carrinho->cupao;
        $descontocupao = $cupao ? $cupao->valor : 0;
        //Vai buscar as linhas carrinho
        // Vai buscar as linhas carrinho
        $linhasCarrinho = $carrinho->linhacarrinhos;
        //Vai buscar as linhas carrinho e verifica se tem stock se nao estiver aparece uma mensagem de erro a dizer para remover produto do carrinho
        foreach ($linhasCarrinho as $linha) {
            $produto = Produto::findOne($linha->produto_id);
            if ($produto->stockdisponivel < $linha->quantidade) {
                Yii::$app->session->setFlash('error', 'O produto ' . $produto->nome . ' não tem stock suficiente. Remova o produto do carrinho.');
                return $this->redirect(['carrinho/index']);
            }
        }

        // Calcula o subtotal
        $subtotal = 0;
        foreach ($linhasCarrinho as $linha) {
            $subtotal += $linha->preco_unitario * $linha->quantidade;
        }

        // Calcula o valor total com desconto
        $totalComDesconto = $subtotal - $descontocupao;

        // Calcula o IVA
        $totalIVA = 0;
        foreach ($linhasCarrinho as $linha) {
            $totalIVA += ($linha->preco_unitario * $linha->produto->iva->taxa / 100) * $linha->quantidade;
        }

        return $this->render('checkout', [
            'carrinho' => $carrinho,
            'linhasCarrinho' => $carrinho->linhacarrinhos,
            'metodospagamento' => $metodospagamento,
        ]);

    }

    //Função para finalizar compra e gerar a fatura
    public function actionFinalizarCompra($metodopagamento_id)
    {

        $idUtilizador = Yii::$app->user->id;
        // Verificar se o utilizador tem carrinho ativo
        $carrinho = Carrinho::findOne(['utilizadorperfil_id' => Yii::$app->user->id]);

        // Verificar se o carrinho existe
        if (!$carrinho) {
            Yii::$app->session->setFlash('error', 'Carrinho não encontrado.');
            Yii::error('Carrinho não encontrado para o utilizador ID: ' . $idUtilizador, __METHOD__);
            return $this->redirect(['carrinho/index']);
        }

        // Verificar se o carrinho tem produtos
        if (count($carrinho->linhacarrinhos) == 0) {
            Yii::$app->session->setFlash('error', 'Carrinho vazio.');
            Yii::error('Carrinho vazio para o utilizador ID: ' . $idUtilizador, __METHOD__);
            return $this->redirect(['carrinho/index']);
        }

        $metodoPagamento = Metodopagamento::findOne($metodopagamento_id);
        if (!$metodoPagamento) {
            Yii::$app->session->setFlash('error', 'Selecione um método de pagamento. Este foi o detetado var_dump: ' . var_dump($metodoPagamento));
            return $this->redirect(['carrinho/checkout']);
        } else {
            Yii::$app->session->setFlash('success', 'Método de pagamento selecionado com sucesso. este é o id do metodo de pagamento: ' . $metodoPagamento->id);
        }

        // Verificar se o carrinho tem um cupão
        if ($carrinho->cupao_id != null) {
            $cupao = Cupao::findOne($carrinho->cupao_id);
        } else {
            $cupao = null;
        }
        $desconto = $cupao ? $cupao->valor : 0;
        $valorTotal = 0;
        $valorIVA = 0;
        $subtotal = 0;

        // Vai buscar as linhas carrinho
        $linhasCarrinho = $carrinho->linhacarrinhos;

        // Calcula o subtotal
        foreach ($linhasCarrinho as $linha) {
            $subtotal += $linha->produto->preco * $linha->quantidade;
            $valorIVA += ($linha->produto->preco * $linha->produto->iva->taxa / 100) * $linha->quantidade;
        }

        // Calcula o valor total com desconto
        $valorTotal = $subtotal - $desconto;

        // Criar a fatura
        $fatura = new Fatura();
        $fatura->datafatura = date('Y-m-d H:i:s');
        $fatura->totalciva = $valorIVA;
        $fatura->subtotal = $subtotal;
        $fatura->valor_total = $valorTotal;
        $fatura->estado = 'Pago';
        $fatura->descontovalor = $desconto;
        $fatura->datapagamento = date('Y-m-d H:i:s');
        $fatura->utilizadorperfil_id = $idUtilizador;
        $fatura->metodopagamento_id = (int)$metodopagamento_id;
        $fatura->cupao_id = $carrinho->cupao_id;


        if ($fatura->save()) {
            //Adiciona agora pontos fideliade ao utilizador pela compra
            $pontosganhos = $valorTotal * 0.2;
            $utilizador = Utilizadorperfil::findOne($idUtilizador);
            $utilizador->pontosacumulados += $pontosganhos;
            if ($utilizador->save()) {
                Yii::$app->session->setFlash('success', 'Pontos de fidelidade adicionados com sucesso! Ganhou ' . $pontosganhos . ' pontos.');
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao adicionar pontos de fidelidade.');
            }

            // Agora atribui as linhas fatura
            foreach ($linhasCarrinho as $linha) {
                $produto = Produto::findOne($linha->produto_id);
                $linhaFatura = new LinhaFatura();

                if ($linha->quantidade == 1) {
                    // Se a quantidade é 1, podemos proceder como estava
                    $linhaFatura->quantidade = 1;
                    $linhaFatura->precounitario = $linha->produto->preco;
                    $linhaFatura->subtotal = $linha->produto->preco * $linha->quantidade;
                    $linhaFatura->fatura_id = $fatura->id;
                    $linhaFatura->desconto_id = $linha->produto->desconto_id;
                    $linhaFatura->iva_id = $linha->produto->iva_id;
                    $linhaFatura->produto_id = $linha->produto_id;

                    // Verifica a chave digital
                    $chaveDigital = Chavedigital::find()->where(['produto_id' => $linha->produto_id, 'estado' => 'nao usada'])->one();
                    if ($chaveDigital) {
                        $linhaFatura->chavedigital_id = $chaveDigital->id;
                        $chaveDigital->estado = 'usada';
                        $chaveDigital->datavenda = date('Y-m-d H:i:s');
                        $chaveDigital->save();

                        // Salva cada linha de fatura
                        if (!$linhaFatura->save()) {
                            Yii::error('Erro ao salvar linha de fatura: ' . json_encode($linhaFatura->errors), __METHOD__);
                            Yii::$app->session->setFlash('error', 'Erro ao salvar linha de fatura. Tente novamente.');
                            $fatura->estado = 'Erro';  // Marca a fatura como erro
                            break;
                        }

                    } else {
                        Yii::$app->session->setFlash('error', 'O produto ' . $produto->nome . ' não tem chaves disponíveis suficientes. Por favor, contacte o suporte.');
                        $fatura->estado = 'Erro';  // Marca a fatura como erro
                        break;  // Interrompe o processamento se não houver chave
                    }
                } else {
                    // Se a quantidade for maior que 1, cria uma linha para cada chave digital
                    $chavesDigitaisDisponiveis = Chavedigital::find()
                        ->where(['produto_id' => $linha->produto_id, 'estado' => 'nao usada'])
                        ->limit($linha->quantidade)
                        ->all();

                    if (count($chavesDigitaisDisponiveis) == $linha->quantidade) {
                        foreach ($chavesDigitaisDisponiveis as $chave) {
                            $linhaFatura = new LinhaFatura();
                            $linhaFatura->chavedigital_id = $chave->id;
                            $linhaFatura->quantidade = 1;
                            $linhaFatura->precounitario = $linha->produto->preco;
                            $linhaFatura->subtotal = $linha->produto->preco;
                            $linhaFatura->fatura_id = $fatura->id;
                            $linhaFatura->desconto_id = $linha->produto->desconto_id;
                            $linhaFatura->iva_id = $linha->produto->iva_id;
                            $linhaFatura->produto_id = $linha->produto_id;

                            // Marca a chave digital como usada
                            $chave->estado = 'usada';
                            $chave->datavenda = date('Y-m-d H:i:s');
                            $chave->save();

                            // Salva cada linha de fatura
                            if (!$linhaFatura->save()) {
                                Yii::error('Erro ao salvar linha de fatura: ' . json_encode($linhaFatura->errors), __METHOD__);
                                Yii::$app->session->setFlash('error', 'Erro ao salvar linha de fatura. Tente novamente.');
                                $fatura->estado = 'Erro';  // Marca a fatura como erro
                                break;
                            }
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'O produto ' . $produto->nome . ' não tem chaves disponíveis suficientes. Por favor, contacte o suporte.');
                        $fatura->estado = 'Erro';  // Marca a fatura como erro
                        break;  // Interrompe o processo de fatura
                    }
                }

                // Atualiza o estoque do produto apenas uma vez, após processar todas as linhas
                $produto->stockdisponivel -= $linha->quantidade;
                $produto->save();
            }

            // Limpar o carrinho
            foreach ($linhasCarrinho as $linha) {
                $linha->delete();
            }

            // Limpar o cupão se houver
            if ($carrinho->cupao_id != null) {
                $cupao->ativo = 0;
                $carrinho->cupao_id = null;
                $cupao->save();
                $carrinho->save();
            }

            // Marcar a fatura como "Pago" se tudo ocorrer corretamente
            if ($fatura->estado != 'Erro') {
                $fatura->estado = 'Pago';
                $fatura->save();
            }

            Yii::$app->session->setFlash('success', 'Compra efetuada com sucesso!');
        } else {
            Yii::error('Erro ao criar a fatura: ' . json_encode($fatura->errors), __METHOD__);
            Yii::$app->session->setFlash('error', 'Erro ao finalizar a compra. Tente novamente.');
            return $this->redirect(['carrinho/checkout']);
        }

        return $this->redirect(['fatura/view', 'id' => $fatura->id]);

    }

}
