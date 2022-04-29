<?php

namespace App\Domain\Package\CapitalGains\Sale;

use App\Domain\Entity\Operation;
use App\Domain\Package\CapitalGains\SingletonStater;
use App\Domain\Package\CapitalGains\Sale\ProfitCalculator;
use App\Domain\Package\CapitalGains\Sale\PrejudiceCalculator;
use App\Domain\Package\CapitalGains\BaseProcessor;

class SaleProcessor extends BaseProcessor
{
    private ProfitCalculator $profitCalculator;

    public function __construct()
    {
        $this->profitCalculator    = new ProfitCalculator();
        $this->prejudiceCalculator = new PrejudiceCalculator();
    }

    public function handle(Operation $operation): self
    {
        $key = $operation->getUnitCost();

        ($this->isProfilable($operation))
            ? $this->handleProfit($operation)
            : $this->handlePrejudice($operation);

        return $this->end($operation);
    }

    private function end(Operation $operation): self
    {
        $this->updateTotal($operation);
        $this->updateCapital($this->getResult()->getLiquid());
        return $this;
    }

    private function handlePrejudice(Operation $operation): void
    {
        $this->result = $this->prejudiceCalculator->calculate($operation);
    }

    private function handleProfit(Operation $operation): void
    {
        $this->result = $this->profitCalculator->calculate($operation);
    }

    private function updateTotal(Operation $operation): void
    {
        $total = SingletonStater::getTotal();
        $total -= $operation->getQuantity();

        $this->setTotal($total);
    }
}