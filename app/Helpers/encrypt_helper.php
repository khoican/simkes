<?php
if (!function_exists('format_encrypt')) {
    function format_encrypt($data) {
        $method = "AES-256-CBC";
        $method = "AES-256-CBC";
        $key = "barangsiapabarangsayahiyahiyahiya";
        $options = 0;
        $iv = '1234567891011121';

        $encryptedData = openssl_encrypt($data, $method, $key, $options,$iv);
        return $encryptedData;
    }
}