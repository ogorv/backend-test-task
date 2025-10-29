<?php

declare(strict_types=1);

namespace App\Enum;

/**
 * @method static cases()
 */
trait GettingValuesTrait
{
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}