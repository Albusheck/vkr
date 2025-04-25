<?php

namespace app\components\calculator\queue;

use yii\console\Controller;
use yii\helpers\Console;
use yii\console\widgets\Table;

class ResultRenderer
{
    private Controller $stdOutWriter;

    public function __construct(Controller $stdOutWriter)
    {
        $this->stdOutWriter = $stdOutWriter;
    }

    private function renderRequest(array $state): void
    {
        $message = "Выполнен запрос на расчет стоимости:\n" .
            "Месяц - " . mb_convert_case($state['request']['month'], MB_CASE_TITLE, 'UTF-8') . "\n" .
            "Тоннаж - {$state['request']['tonnage']}\n" .
            "Тип сырья - " . mb_convert_case($state['request']['type'], MB_CASE_TITLE, 'UTF-8') . "\n";

        $this->stdOutWriter->stdout($message, Console::FG_CYAN);
    }

    private function renderSuccess(array $state): void
    {
        $this->renderRequest($state);

        $message = "Выполнен расчет стоимости по заданным параметрам.\n" .
            "Стоимость доставки: {$state['result']['price']} у.е.\n" .
            "Таблица, примененная расчета стоимости для типа сырья \"" . mb_convert_case($state['request']['type'], MB_CASE_TITLE, 'UTF-8') . "\":\n";

        $this->stdOutWriter->stdout($message, Console::FG_GREEN);

        $months = array_keys($state['result']['price_list']);
        $rows = [];

        foreach ($state['result']['price_list'] as $priceList) {

            foreach ($priceList as $tonnage => $price) {

                if (isset($rows[$tonnage]) === false) {
                    $rows[$tonnage][] = $tonnage;
                }

                $rows[$tonnage][] = $price;
            }

        }

        $tableContent = Table::widget([
            'headers' => array_merge(['м/т'], $months),
            'rows' => $rows,
        ]);

        $this->stdOutWriter->stdout($tableContent, Console::FG_GREEN);

        $this->stdOutWriter->stdout("\n\n");
    }

    private function renderError(array $state): void
    {
        $this->renderRequest($state);

        $message = "Расчет стоимости не выполнен.\n" .
            "Причина: {$state['error']}";

        $this->stdOutWriter->stdout($message, Console::FG_RED);

        $this->stdOutWriter->stdout("\n\n");
    }

    public function render(array $state): void
    {
        if (isset($state['result']) === true) {
            $this->renderSuccess($state);
            return;
        }

        if (isset($state['error']) === true) {
            $this->renderError($state);
            return;
        }

        throw new \InvalidArgumentException('Неизвестное состояние. Отрисовка невозможна');
    }
}