<?php

namespace App\Infrastructure\Http;

use App\Application\DTO\TransactionDTO;
use App\Application\Services\CapitalGainsService;
use App\Infrastructure\Contracts\InputAdapterInterface;
use App\Infrastructure\Adapter\RestOutputAdapter;

class RestInputController implements InputAdapterInterface
{
    private CapitalGainsService $service;

    public function __construct()
    {
        $this->service = new CapitalGainsService();
        $this->output  = new RestOutputAdapter();
    }

    public function handle(mixed $data)
    {
        $data = json_decode(trim($data['data']), true);

        if (!is_array($data)) {
            return $this->output->handle([
                'message' => 'Infelizmente o dado informado encontra-se num formato inválido, tente novamente.'
            ]);
        }

        $transactionDTO = TransactionDTO::fromArray($data);

        $result = $this->service->process($transactionDTO);

        $this->output->handle($result);
    }
}