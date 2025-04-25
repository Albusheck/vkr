<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Авторизация';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput(['value' => Yii::$app->session->getFlash('loginData')['email'] ?? '']) ?>

    <?= $form->field($model, 'password')->passwordInput(['value' => Yii::$app->session->getFlash('loginData')['password'] ?? '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>
