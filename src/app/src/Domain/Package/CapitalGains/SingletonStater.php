<?php

namespace App\Domain\Package\CapitalGains;

use App\Application\Helper\Facade;

class SingletonStater
{
    private static bool $loaded         = false;
    private static float $weightAverage = Facade::ZERO;
    private static float $capital       = Facade::ZERO;
    private static int $total           = 0;

    protected function __clone()
    {

    }

    protected function __construct()
    {

    }

    public static function load()
    {
        if (!self::$loaded) {
            self::$loaded = true;
        }
    }

    public static function reset()
    {
        self::setTotal(0);
        self::setCapital(Facade::ZERO);
        self::setWeightAverage(Facade::ZERO);
    }

    public static function updateCapital(float $value)
    {
        self::$capital += $value;
    }

    public static function setCapital(float $value)
    {
        self::$capital = $value;
    }

    public static function setWeightAverage(float $value)
    {
        self::$weightAverage = $value;
    }

    public static function setTotal(int $total)
    {
        self::$total = $total;
    }

    public static function getTotal(): int
    {
        return self::$total;
    }

    public static function getCapital(): float
    {
        return self::$capital;
    }

    public static function getWeightAverage(): float
    {
        return self::$weightAverage;
    }
}