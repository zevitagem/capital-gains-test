<?php

namespace App\Application\Traits;

trait OperationAttributes
{
    public string $operation;
    public float $unitCost;
    public int $quantity;

    public function getOperation(): string
    {
        return $this->operation;
    }

    public function getUnitCost(): float
    {
        return $this->unitCost;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function isSell(): bool
    {
        return ($this->operation == 'sell');
    }
}