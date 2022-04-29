<?php
declare(strict_types=1);

namespace App\Domain\Contracts;

use App\Domain\Entity\Tax;
use App\Domain\Package\CapitalGains\ConsolidatedResult;

interface ProcessorInterface
{
    public function getTax(): Tax;

    public function getResult(): ConsolidatedResult;
}