<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use app\components\calculator\queue\ResultRenderer;
use app\models\CalculationRepository;
use app\models\CalculationForm;
use app\components\calculator\CalculationResultsService;

class BackgroundCalculatorController extends Controller
{
    public $month = "";
    public $type = "";
    public $tonnage = "";
    public function options($actionID) : array
    {
        return ["month","type","tonnage"];
    }
    public function actionIndex() : void 
    {
        $form = new CalculationForm([
            'month' => $this->month,
            'type' => $this->type,
            'tonnage' => $this->tonnage,
        ]);
        

        if (!$form->validate()) {
            $this->stdout('Ошибка введенных данных.' . PHP_EOL, Console::FG_RED);
            if ($form->month == '') {
                $this->stdout('Необходимо указать месяц'. PHP_EOL, Console::FG_RED);
            }
            if ($form->type == '') {
                $this->stdout('Необходимо указать тип сырья'. PHP_EOL, Console::FG_RED);
            }
            if ($form->tonnage == '') {
                $this->stdout('Необходимо указать тоннаж'. PHP_EOL, Console::FG_RED);
            }
            exit(ExitCode::UNSPECIFIED_ERROR);
        }

                // Инстанцируем необходимые компоненты
        $repository = new CalculationRepository(
            \Yii::$app->params['lists'],
            \Yii::$app->params['prices'],
        );
        //$service = new CalculationResultsService($repository);
        $renderer = new ResultRenderer($this);

        // Выполняем расчет
        $basePath = \Yii::getAlias('@runtime') . DIRECTORY_SEPARATOR . 'queue';

        (new CalculationResultsService($repository))->handle($form);

        $jobs = scandir($basePath);
        $jobs = array_diff($jobs, array('.', '..'));

        $job = reset($jobs);
        $path = $basePath . DIRECTORY_SEPARATOR . $job;

        $state = json_decode(file_get_contents($path), true);

        $renderer->render($state);

        foreach ($jobs as $job) {
            $path = $basePath . DIRECTORY_SEPARATOR . $job;
            unlink($path);
        }
    }
}