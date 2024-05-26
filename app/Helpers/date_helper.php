<?php
if (!function_exists('format_date')) {
    function format_date($date) {
        date_default_timezone_set('Asia/Jakarta');
        $date = new DateTime($date);
        $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        return $formatter->format($date);
    }
}