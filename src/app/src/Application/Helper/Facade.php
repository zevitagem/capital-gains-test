<?php

namespace App\Application\Helper;

use App\Domain\Contracts\MapperValuesInterface;
use App\Domain\Package\CapitalGains\SingletonStater;

class Facade
{
    const RATE = 0.20;
    const ZERO = 0.00;

    public static function getPurchaseMap(): MapperValuesInterface
    {
        return SingletonStater::getPurchaseContainer();
    }

    public static function env(string $key)
    {
        $envs = parse_ini_file('../.env');

        return $envs[$key] ?? null;
    }

    public static function numberFormat(float $value)
    {
        return number_format($value, 2, '.', '');
    }
}