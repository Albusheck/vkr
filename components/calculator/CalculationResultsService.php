<?php

namespace app\components\calculator;

use yii\base\Model;
use app\models\CalculationRepository;

use app\models\CalculationForm;

class CalculationResultsService
{
    private CalculationRepository $repository;

    public function __construct(CalculationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(CalculationForm $context): void
    {
        $basePath = \Yii::getAlias('@runtime') . DIRECTORY_SEPARATOR . 'queue';

        if (is_dir($basePath) === false) {
            mkdir($basePath, 0755);
        }

        $jobName = 'job-' . time() . '.json';

        $state = [
            'request' => $context->getAttributes(),
        ];

        $isPriceExists = $this->repository->isPriceExists(
            $context->month,
            (int) $context->tonnage,
            $context->type,
            $context->year,
        );

        if ($isPriceExists === true) {

            $state['result']['price'] = $this->repository->getPrice(
                $context->month,
                (int) $context->tonnage,
                $context->type,
                $context -> year,
            );

            $state['result']['price_list'] = $this->repository->getPriceListByRawType($context->type);
        }

        if ($isPriceExists === false) {
            $state['error'] = 'Стоимость для указанных параметров отсутствует';
        }

        file_put_contents($basePath . DIRECTORY_SEPARATOR . $jobName, json_encode($state, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
    }
}