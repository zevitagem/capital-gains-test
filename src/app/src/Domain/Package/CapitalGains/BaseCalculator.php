<?php

namespace App\Domain\Package\CapitalGains;

use App\Domain\Entity\Operation;
use App\Domain\Package\CapitalGains\SingletonStater;
use App\Domain\Package\CapitalGains\ConsolidatedResult;

abstract class BaseCalculator
{
    protected function getGross(Operation $operation): float
    {
        $weightAverage = SingletonStater::getWeightAverage();

        $oldValue = $weightAverage * $operation->getQuantity();
        $newValue = $operation->getUnitCost() * $operation->getQuantity();

        return $newValue - $oldValue;
    }

    abstract public function calculate(Operation $operation): ConsolidatedResult;
}