<?php 

if (!function_exists('format_numerik')) {
    function format_numerik($value) {
        $format = number_format($value, 0, ',', '.');
        return 'Rp.' . $format;
    }
}