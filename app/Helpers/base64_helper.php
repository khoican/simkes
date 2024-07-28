<?php

if (!function_exists('base64_encode_image')) {
    function base64_encode_image($filename) {
        if (file_exists($filename)) {
            $imageData = base64_encode(file_get_contents($filename));
            $src = 'data: '.mime_content_type($filename).';base64,'.$imageData;
            return $src;
        } else {
            log_message('error', 'File not found: ' . $filename);
            return '';
        }
    }
}