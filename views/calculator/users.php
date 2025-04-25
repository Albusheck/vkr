<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Управление ролями';
?>


<h1><?= Html::encode($this->title) ?></h1>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php elseif (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>
<style>
    .table-responsive {
        overflow-y: auto; 
        white-space: nowrap; 
    }
    table {
        width: 100%; /* Гарантирует, что таблица займет всю доступную ширину */
    }
</style>
<div class="role-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'userId')->dropDownList($model->getUsers(), ['prompt' => 'Выберите пользователя']) ?>

    <?= $form->field($model, 'roleName')->dropDownList($model->getRoles(), ['prompt' => 'Выберите роль']) ?>

    <div class="form-group">
        <?= Html::submitButton('Назначить роль', ['class' => 'btn btn-success', 'name' => 'assign', 'value' => '1']) ?>
        <?= Html::submitButton('Снять роль', ['class' => 'btn btn-danger', 'name' => 'revoke', 'value' => '1']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<h2>Список пользователей и их роли</h2>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Роли</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usersWithRoles as $user): ?>
                <tr>
                    <td><?= Html::encode($user['id']) ?></td>
                    <td><?= Html::encode($user['name']) ?></td>
                    <td><?= Html::encode($user['email']) ?></td>
                    <td><?= Html::encode(implode(', ', $user['roles'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>   
</div>

