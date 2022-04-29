<?php

namespace App\Domain\Entity;

use App\Application\Helper\Facade;

class Tax
{
    public function __construct(public float $tax)
    {
        
    }

    public function __invoke()
    {
        return (object) ['tax' => Facade::numberFormat($this->tax)];
    }
}