<?php

if (!function_exists('full_name')) {
    /**
     * Get full name from first name and last name
     */
    function full_name(?string $firstName = null, ?string $lastName = null): string
    {
        $firstName = trim($firstName ?? '');
        $lastName = trim($lastName ?? '');

        return trim($firstName . ' ' . $lastName);
    }
}

if (!function_exists('to_persian_digits')) {
    /**
     * Convert English digits to Persian digits.
     */
    function to_persian_digits(string $value): string
    {
        $english = ['0','1','2','3','4','5','6','7','8','9'];
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];

        return str_replace($english, $persian, $value);
    }
}

if (!function_exists('to_english_digits')) {
    /**
     * Convert Persian digits to English digits.
     */
    function to_english_digits(string $value): string
    {
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        $english = ['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9'];

        return str_replace($persian, $english, $value);
    }
}

