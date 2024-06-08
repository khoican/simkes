<?php
if (!function_exists('format_time')) {
    function format_time($time) {
        $time = new DateTime($time);
        return $time->format('H:i');
    }
}