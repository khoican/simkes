<?php

if (!function_exists('calculate_age')) {
    /**
     * @param string
     * @return int
     */
    function calculate_age($birthDate)
    {
        $birthDate = new DateTime($birthDate);
        $today = new DateTime('today');
        $age = $today->diff($birthDate)->y;
        return $age;
    }
}