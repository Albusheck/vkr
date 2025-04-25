<?php

namespace app\models;

class CalculationRepository
{
    private array $listsConfig;

    private array $pricesConfig;

    public function __construct(array $listsConfig, array $pricesConfig)
    {
        $this->listsConfig = $listsConfig;
        $this->pricesConfig = $pricesConfig;
    }

    public function getMonths(): array
    {
        return $this->listsConfig['months'];
    }

    public function getTonnages(): array
    {
        return $this->listsConfig['tonnages'];
    }

    public function getTypes(): array
    {
        return $this->listsConfig['raw_types'];
    }

    public function getYears(): array
    {
        return $this->listsConfig['years'];
    }
    public function isPriceExists(string $month, int $tonnage, string $type, int $year): bool
    {
        $tonnageKey = number_format((float)$tonnage, 2, '.', '');
        return isset($this->pricesConfig[$type][$month][$year][$tonnageKey]);
    }

    public function getPrice(string $month, int $tonnage, string $type, int $year): int
    {
        $tonnageKey = number_format((float)$tonnage, 2, '.', '');

        return $this->pricesConfig[$type][$month][$year][$tonnageKey];
    }

    public function getPriceListTonnagesByRawType(string $type): array
    {
        $firstMonth = array_key_first($this->pricesConfig[$type]);

        return array_keys($this->pricesConfig[$type][$firstMonth]);
    }

    public function getPriceListMonthsByRawType(string $type): array
    {
        return array_keys($this->pricesConfig[$type]);
    }

    public function getPriceListYearsByRawTypeAndMonth(string $type, string $month): array
    {
        return $this->pricesConfig[$type][$month];
    }
    public function getPriceListPriceByRawTypeAndMonth(string $type, string $month): array
    {
        return $this->pricesConfig[$type][$month];
    }

    public function getPriceListPriceByRawTypeAndMonthAndYear(string $type, string $month, int $year): array
    {
        return $this->pricesConfig[$type][$month][$year];
    }

    public function getPriceListByRawType(string $rawType): array
    {
        return $this->pricesConfig[$rawType];
    }

    public function getPriceList(): array
    {
        return $this->pricesConfig;
    }

}