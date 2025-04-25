<!-- calculation_result.php -->

<?php if (\Yii::$app->session->hasFlash('error') === true): ?>
    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="alert alert-danger">
                <?= \Yii::$app->session->getFlash('error') ?>
            </div>
        </div>
    </div>
<?php endif ?>

<?php if ($showCalculation === true): ?>
    <div id="result" class="mb-4">
        <div class="row justify-content-center mt-5">
            <div class="col-md-3 me-3">
                <div class="card shadow-lg">
                    <div class="card-header bg-success text-white" style="font-weight: bold; font-size: 17px;">
                        Введенные данные:
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong> Месяц: </strong>
                            <?= mb_convert_case($model->month,  MB_CASE_TITLE, 'UTF-8') ?>
                        </li>
                        <li class="list-group-item">
                            <strong> Тоннаж: </strong>
                            <?= mb_convert_case($model->tonnage, MB_CASE_TITLE, 'UTF-8') ?>
                        </li>
                        <li class="list-group-item">
                            <strong> Тип сырья: </strong>
                            <?= mb_convert_case($model->type, MB_CASE_TITLE, 'UTF-8') ?>
                        </li>
                        <li class="list-group-item">
                            <strong> Итог, руб.: </strong>
                            <?= $repository->getPrice($model->month, (int) $model->tonnage, $model->type) ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 table-responsive border rounded-1 shadow-lg p-0">
                <table class="table table-hover table-striped text-center mb-0">
                    <thead>
                        <tr>
                            <th>Т/M</th>
                            <?php foreach ($repository->getPriceListTonnagesByRawType($model->type) as $tonnage): ?>
                                <th><?= $tonnage ?></th>
                            <?php endforeach ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($repository->getPriceListMonthsByRawType($model->type) as $month): ?>
                            <tr>
                                <td>
                                    <?= mb_convert_case($month, MB_CASE_TITLE, 'UTF-8') ?>
                                </td>
                                <?php foreach ($repository->getPriceListPriceByRawTypeAndMonth($model->type, $month) as $tonnage => $price): ?>
                                    <td
                                        <?php
                                            if ($model->month === $month && (int) $model->tonnage === (int) $tonnage) {
                                                echo 'class="with-border"';
                                            }
                                        ?>
                                    >
                                        <?= $price ?>
                                    </td>
                                <?php endforeach ?>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif ?>
