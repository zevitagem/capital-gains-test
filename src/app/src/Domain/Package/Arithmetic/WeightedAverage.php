<?php

namespace App\Domain\Package\Arithmetic;

use App\Domain\Contracts\MapperValuesInterface;
use App\Application\Helper\Facade;

class WeightedAverage
{
    private int $divider;

    public function calculate(
        int $currentTotal, float $currentAverage, MapperValuesInterface $mapper
    ): float
    {
        $dividend = $this->dividend($currentTotal, $currentAverage, $mapper);
        $divider  = $this->divider($currentTotal, $mapper);

        return $dividend / $divider;
    }

    private function dividend(
        int $currentTotal, float $currentAverage, MapperValuesInterface $mapper
    ): float
    {
        $new = Facade::ZERO;
        foreach ($mapper->getArrayCopy() as $unitCost => $quantity) {
            $new += $quantity * $unitCost;
        }

        if ($currentAverage == Facade::ZERO) {
            $currentAverage = $unitCost;
        }

        return ($currentTotal * $currentAverage) + $new;
    }

    private function divider(int $currentTotal, MapperValuesInterface $mapper): int
    {
        $new = array_sum($mapper->getArrayCopy());

        $this->setDivider($new);

        return $currentTotal + $new;
    }

    private function setDivider(int $divider): void
    {
        $this->divider = $divider;
    }

    public function getDivider(): int
    {
        return $this->divider;
    }
}