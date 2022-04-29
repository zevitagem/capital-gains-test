<?php

namespace App\Application\Services;

use App\Application\DTO\TransactionDTO;
use App\Domain\Package\CapitalGains\OrchestratorProcessor;

class CapitalGainsService
{
    private OrchestratorProcessor $orchestrator;

    public function __construct()
    {
        $this->orchestrator = new OrchestratorProcessor();
    }

    public function process(TransactionDTO $transaction): array
    {
        $taxs = [];

        foreach ($transaction->toArray() as $operationDTO) {

            $operation = $operationDTO->toDomain();

            $processor = $this->orchestrator->handle($operation);

            $taxs[] = $processor->getTax()();
        }

        return $taxs;
    }
}