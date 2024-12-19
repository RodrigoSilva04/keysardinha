<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<h1>Checkout</h1>

<h2>Itens do Carrinho</h2>
<table>
    <thead>
    <tr>
        <th>Produto</th>
        <th>Quantidade</th>
        <th>Preço Unitário</th>
        <th>Subtotal</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($itensCarrinho as $item): ?>
        <tr>
            <td><?= $item->produto->nome ?></td>
            <td><?= $item->quantidade ?></td>
            <td><?= Yii::$app->formatter->asCurrency($item->produto->preco) ?></td>
            <td><?= Yii::$app->formatter->asCurrency($item->subtotal) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<h3>Total: <?= Yii::$app->formatter->asCurrency($totalCarrinho) ?></h3>

<h2>Método de Pagamento</h2>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($modelFatura, 'metodopagamento_id')->dropDownList(
    $metodosPagamento,
    ['prompt' => 'Escolha um método de pagamento']
) ?>

<div class="form-group">
    <?= Html::submitButton('Pagar', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
