<?php
use yii\helpers\Html;

$this->title = 'Профиль пользователя';
?>

<div class="container mt-4">
    <h2>Профиль пользователя</h2>

    <table class="table table-bordered">
        <tr>
            <th>Имя:</th>
            <td><?= Html::encode($user->name) ?></td>
        </tr>
        <tr>
            <th>Email:</th>
            <td><?= Html::encode($user->email) ?></td>
        </tr>
        <tr>
            <th>Пароль:</th>
            <td>********** (скрыто)</td>
        </tr>
        <tr>
            <th>Дата создания профиля:</th>
            <td><?= Html::encode($user->created_at) ?></td>
        </tr>
    </table>
</div>
