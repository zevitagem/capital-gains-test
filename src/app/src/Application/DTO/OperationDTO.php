<?php

namespace App\Application\DTO;

use App\Application\DTO\DTO;
use App\Application\Traits\OperationAttributes;
use App\Domain\Entity\Operation;
use App\Domain\Contracts\EntityInterface;

class OperationDTO extends DTO
{

    use OperationAttributes;

    public function toDomain(): ?EntityInterface
    {
        return new Operation(
            $this->getOperation(), $this->getUnitCost(), $this->getQuantity(),
        );
    }

    protected function trySetCasePropertyNotExists(string $key, $value): bool
    {
        $valid = false;
        
        switch ($key) {
            case 'unit-cost':
                $this->unitCost = $value;
                $valid          = true;
                break;
        }

        return $valid;
    }
}