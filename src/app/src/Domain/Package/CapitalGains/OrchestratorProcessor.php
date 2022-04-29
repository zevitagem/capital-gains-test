<?php

namespace App\Domain\Package\CapitalGains;

use App\Domain\Entity\Operation;
use App\Domain\Package\CapitalGains\Sale\SaleProcessor;
use App\Domain\Package\CapitalGains\Purchase\PurchaseProcessor;
use App\Domain\Package\CapitalGains\SingletonStater;

class OrchestratorProcessor
{
    private SaleProcessor $sales;
    private PurchaseProcessor $purchase;

    public function __construct()
    {
        $this->sales = new SaleProcessor();
        $this->purchase = new PurchaseProcessor();
    }

    public function handle(Operation $operation)
    {
//        echo PHP_EOL;
//        echo json_encode((array)$operation);
//        echo PHP_EOL;
//        echo json_encode([
//           'antes::total_acoes' => SingletonStater::getTotal(),
//           'antes::total_capital' => SingletonStater::getCapital(),
//           'antes::media_ponderada' => SingletonStater::getWeightAverage(),
//        ]);
        
        if ($operation->isSell()) {
            $result = $this->sales->handle($operation);
        } else {
            $result = $this->purchase->handle($operation);
        }
        
//        echo PHP_EOL;
//        echo json_encode([
//           'depois::total_acoes' => SingletonStater::getTotal(),
//           'depois::total_capital' => SingletonStater::getCapital(),
//           'depois::media_ponderada' => SingletonStater::getWeightAverage(),
//        ]);

        return $result;
    }
}