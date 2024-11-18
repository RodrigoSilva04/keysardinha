<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Registar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup d-flex flex-column align-items-center justify-content-center" style="min-height: 100vh;">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Por favor preencha os com os seus dados</p>

    <div class="row justify-content-center w-100">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control']) ?>

            <?= $form->field($model, 'email')->textInput(['class' => 'form-control']) ?>

            <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control']) ?>

            <div class="form-group text-center">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

