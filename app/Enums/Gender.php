<?php

namespace App\Enums;

class Gender
{
    const MALE = 0;      // مرد
    const FEMALE = 1;   // زن

    /**
     * Get all gender options
     *
     * @return array
     */
    public static function all(): array
    {
        return [
            self::MALE => 'مرد',
            self::FEMALE => 'زن',
        ];
    }

    /**
     * Get gender label in Persian
     *
     * @param int $value
     * @return string|null
     */
    public static function getLabel(int $value): ?string
    {
        return self::all()[$value] ?? null;
    }

    /**
     * Check if value is valid
     *
     * @param int $value
     * @return bool
     */
    public static function isValid(int $value): bool
    {
        return array_key_exists($value, self::all());
    }

    /**
     * Get all values
     *
     * @return array
     */
    public static function values(): array
    {
        return array_keys(self::all());
    }
}

