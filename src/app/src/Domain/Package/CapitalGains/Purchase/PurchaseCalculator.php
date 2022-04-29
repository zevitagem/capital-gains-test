<?php

namespace App\Domain\Package\CapitalGains\Purchase;

use App\Domain\Package\CapitalGains\BaseCalculator;
use App\Domain\Package\CapitalGains\ConsolidatedResult;
use App\Domain\Entity\Operation;
use App\Application\Helper\Facade;

class PurchaseCalculator extends BaseCalculator
{
    public function calculate(Operation $operation): ConsolidatedResult
    {
        $gross  = Facade::ZERO;
        $tax    = Facade::ZERO;
        $liquid = $gross;

        return new ConsolidatedResult($gross, $liquid, $tax);
    }
}