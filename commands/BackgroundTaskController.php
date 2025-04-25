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

class BackgroundTaskController extends Controller
{
    public $demonize = false;
    public function options($actionID)
    {
        return ['demonize'];
    }
    public function actionIndex(): void
    {
        $basePath = \Yii::getAlias('@runtime') . DIRECTORY_SEPARATOR . 'queue';

        $renderer = new ResultRenderer($this);

        $this->stdout('Задачи отсутствуют. Ожидание задач' . PHP_EOL, Console::FG_CYAN);

        while (true) {
        if (is_dir($basePath) === false) {

            $this->stdout('Хранилище задач не определено' . PHP_EOL, Console::FG_RED);

            exit(ExitCode::UNSPECIFIED_ERROR);
        }

        $jobs = scandir($basePath);

        array_splice($jobs, 0, 2);

        foreach ($jobs as $job) {
            $path = $basePath . DIRECTORY_SEPARATOR . $job;

            $state = json_decode(file_get_contents($path), true);

            $renderer->render($state);

            unlink($path);
        }
        if ($this->demonize === false) {
            exit;
        }

        }
    }
}
