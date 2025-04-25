<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\CalculationHistorySearch $searchModel */

$this->title = 'История расчетов';
?>

<div class="container mt-4">
    <h2>История расчетов</h2>

    <?php $form = ActiveForm::begin(['method' => 'get']); ?>
        <?= $form->field($searchModel, 'raw_type')->textInput(['placeholder' => 'Тип сырья'])->label(false) ?>
        <?= $form->field($searchModel, 'tonnage')->textInput(['placeholder' => 'Тоннаж'])->label(false) ?>
        <?= $form->field($searchModel, 'month')->textInput(['placeholder' => 'Месяц'])->label(false) ?>
        <?= $form->field($searchModel, 'created_at')->input('date')->label(false) ?>
        <?= Html::submitButton('Фильтровать', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'user_id',
                'label' => 'Имя пользователя',
                'value' => function($model) {
                    return $model->user->name ?? 'Неизвестно';
                },
                'visible' => Yii::$app->user->can('administrator'), // Только для админов
            ],
            'raw_type',
            'tonnage',
            'month',
            'price',
            'created_at',
        ],
    ]); ?>
</div>
