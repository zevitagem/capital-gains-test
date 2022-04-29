<?php

namespace App\Infrastructure\Command;

use App\Application\DTO\TransactionDTO;
use App\Application\Services\CapitalGainsService;
use App\Infrastructure\Contracts\InputAdapterInterface;
use App\Infrastructure\Adapter\StdoutOutputAdapter;

class LineInputController implements InputAdapterInterface
{
    private CapitalGainsService $service;

    public function __construct()
    {
        $this->service = new CapitalGainsService();
        $this->output  = new StdoutOutputAdapter();
    }

    public function handle(mixed $data)
    {
        $data = json_decode(trim($data), true);

        if (!is_array($data)) {
            echo 'Infelizmente o dado informado encontra-se num formato inválido, tente novamente.';
            return $this->redirect();
        }

        $transactionDTO = TransactionDTO::fromArray($data);

        $result = $this->service->process($transactionDTO);

        $this->output->handle($result);
        $this->redirect();
    }

    public function redirect()
    {
        include 'command_index.php';
    }
}