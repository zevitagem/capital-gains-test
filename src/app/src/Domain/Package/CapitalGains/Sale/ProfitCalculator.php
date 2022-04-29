<?php

namespace App\Domain\Package\CapitalGains\Sale;

use App\Domain\Entity\Operation;
use App\Domain\Package\CapitalGains\SingletonStater;
use App\Application\Helper\Facade;
use App\Domain\Package\CapitalGains\ConsolidatedResult;
use App\Domain\Package\CapitalGains\BaseCalculator;

class ProfitCalculator extends BaseCalculator
{
    private float $limit;

    public function __construct()
    {
        $this->limit = floatval(Facade::env('PROFIT_LIMIT'));
    }

    public function calculate(Operation $operation): ConsolidatedResult
    {
        $gross  = $this->getGross($operation);
        $tax    = Facade::ZERO;
        $liquid = $gross;

        if ($this->hasToPayTax($operation)) {
            $liquid = $this->liquidProfit($gross, $tax);
        }

        return new ConsolidatedResult($gross, $liquid, $tax);
    }

    public function liquidProfit(float $gross, float &$tax): float
    {
        $capital    = SingletonStater::getCapital();
        $isNegative = ($capital < 0);

        if (!$isNegative) {
            $tax    = $gross * Facade::RATE;
            $liquid = $gross - $tax;
            return $liquid;
        }

        $liquid     = $gross;
        $newCapital = $capital + $liquid;

        $tax = Facade::ZERO;
        if ($newCapital > 0) {
            $tax = $newCapital * Facade::RATE;
            $liquid -= $tax;
        }

        return $liquid;
    }

    public function hasToPayTax(Operation $operation): bool
    {
        return (($operation->getQuantity() * $operation->getUnitCost()) > $this->getLimit());
    }

    public function getLimit(): float
    {
        return $this->limit;
    }
}