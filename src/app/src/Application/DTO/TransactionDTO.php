<?php

namespace App\Application\DTO;

use App\Application\DTO\DTO;
use ArrayIterator;
use App\Application\DTO\OperationDTO;

class TransactionDTO extends DTO
{
    private ArrayIterator $operations;

    public function __construct()
    {
        $this->operations = new ArrayIterator();
    }

    public static function fromArray(array $parameters): self
    {
        $dto = new static;
        foreach ($parameters as $row) {
            $operation = OperationDTO::fromArray($row);
            $dto->operations->append($operation);
        }

        return $dto;
    }

    public function toArray(): array
    {
        return (array) $this->operations;
    }
}