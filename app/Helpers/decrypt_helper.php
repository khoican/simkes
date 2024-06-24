<?php
if (!function_exists('format_decrypt')) {
    function format_decrypt ($data) {
        $method = "AES-256-CBC";
        $method = "AES-256-CBC";
        $key = "barangsiapabarangsayahiyahiyahiya";
        $options = 0;
        $iv = '1234567891011121';

        $decryptedData = openssl_decrypt($data, $method, $key, $options,$iv);
        return $decryptedData;
    }
}