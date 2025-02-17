<?php

namespace App\Modules\Traits;

use ReflectionClass;

trait MyConstants
{    
    /**
     * getMyConstants
     *
     * @return array
     */
    static function getMyConstants(): array
    {
        $class = new ReflectionClass(self::class);

        return $class->getConstants();
    }
    
    /**
     * isValidConstant
     *
     * @param  mixed $valueToCheck
     * @return bool
     */
    static function isValidConstant(string $valueToCheck): bool
    {
        $allowed = self::getMyConstants();

        return in_array($valueToCheck, $allowed);
    }
}