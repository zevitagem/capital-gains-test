<?php

namespace App\Domain\Package\CapitalGains\Purchase;

use App\Domain\Entity\Operation;
use App\Domain\Package\Arithmetic\WeightedAverage;
use App\Domain\Package\CapitalGains\SingletonStater;
use App\Domain\Package\CapitalGains\BaseProcessor;
use App\Domain\Package\CapitalGains\Purchase\PurchaseCalculator;
use App\Domain\Package\CapitalGains\Purchase\PurchaseContainer;

class PurchaseProcessor extends BaseProcessor
{
    private WeightedAverage $weightedAverage;
    private PurchaseContainer $purchaseMap;

    public function __construct()
    {
        $this->weightedAverage = new WeightedAverage();
        $this->calculator      = new PurchaseCalculator();
    }

    public function handle(Operation $operation): self
    {
        $this->purchaseMap = new PurchaseContainer();
        $this->purchaseMap->offsetSet(
            $operation->getUnitCost(), $operation->getQuantity()
        );

        $this->calculateAverage();

        return $this->end($operation);
    }

    private function end(Operation $operation): self
    {
        $this->defineResult($operation);
        $this->updateTotal();
        return $this;
    }

    public function defineResult(Operation $operation)
    {
        $this->result = $this->calculator->calculate($operation);
    }

    private function calculateAverage()
    {
        $total   = SingletonStater::getTotal();
        $average = SingletonStater::getWeightAverage();

        $average = $this->weightedAverage->calculate(
            $total, $average, $this->purchaseMap
        );

        SingletonStater::setWeightAverage($average);
    }

    private function updateTotal()
    {
        $this->setTotal($this->weightedAverage->getDivider());
    }
}