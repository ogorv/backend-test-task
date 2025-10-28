<?php

declare(strict_types=1);

namespace App\Helper;

class MathHelper
{
    public function getPercentFromNumber(float $number, float $percent): float
    {
        return 0.01 * $percent * $number;
    }

    /**
     * Return amount without percent
     */
    public function subPercent(float $amount, float $percent): float
    {

        return $amount - $this->getPercentFromNumber($amount, $percent);
    }

    public function addPercent(float $amount, float $percent): float
    {
        return $amount + $this->getPercentFromNumber($amount, $percent);
    }
}