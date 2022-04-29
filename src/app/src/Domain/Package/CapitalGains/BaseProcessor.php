<?php

namespace App\Domain\Package\CapitalGains;

use App\Domain\Entity\Operation;
use App\Domain\Contracts\ProcessorInterface;
use App\Domain\Package\CapitalGains\SingletonStater;
use App\Domain\Package\CapitalGains\ConsolidatedResult;
use App\Domain\Entity\Tax;

abstract class BaseProcessor implements ProcessorInterface
{
    protected ConsolidatedResult $result;

    protected function updateCapital(float $value): void
    {
        SingletonStater::updateCapital($value);
    }

    protected function setTotal(int $total): void
    {
        SingletonStater::setTotal($total);
    }

    protected function isProfilable(Operation $operation): bool
    {
        return ($operation->getUnitCost() > SingletonStater::getWeightAverage());
    }

    public function getResult(): ConsolidatedResult
    {
        return $this->result;
    }

    public function getTax(): Tax
    {
        return $this->getResult()->getTax();
    }
}