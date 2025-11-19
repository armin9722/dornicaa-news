<?php

namespace App\Enums;

class MilitaryServiceStatus
{
    const NONE = 0;        // ندارد (زن)
    const EXEMPT = 1;      // معاف
    const ONGOING = 2;     // در حال انجام
    const COMPLETED = 3;   // انجام شده

    /**
     * Get all military service status options
     *
     * @return array
     */
    public static function all(): array
    {
        return [
            self::NONE => 'ندارد',
            self::EXEMPT => 'معاف',
            self::ONGOING => 'در حال خدمت',
            self::COMPLETED => 'پایان خدمت',
        ];
    }

    /**
     * Get military service status label in Persian
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

