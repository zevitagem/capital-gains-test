<?php

namespace App\Domain\Package\CapitalGains\Sale;

use App\Domain\Entity\Operation;
use App\Domain\Package\CapitalGains\ConsolidatedResult;
use App\Domain\Package\CapitalGains\BaseCalculator;
use App\Application\Helper\Facade;

class PrejudiceCalculator extends BaseCalculator
{
    public function calculate(Operation $operation): ConsolidatedResult
    {
        $gross  = $this->getGross($operation);
        $tax    = Facade::ZERO;
        $liquid = $gross;

        return new ConsolidatedResult($gross, $liquid, $tax);
    }
}