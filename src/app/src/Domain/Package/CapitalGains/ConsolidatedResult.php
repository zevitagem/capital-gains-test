<?php

namespace App\Domain\Package\CapitalGains;

use App\Domain\Entity\Tax;

final class ConsolidatedResult
{
    public function __construct(
        private float $gross, private float $liquid, private float $tax
    )
    {

    }

    public function getGross(): float
    {
        return $this->gross;
    }

    public function getLiquid(): float
    {
        return $this->liquid;
    }

    public function getTax(): Tax
    {
        return new Tax($this->tax);
    }
}