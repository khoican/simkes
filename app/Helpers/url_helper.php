<?php

if (!function_exists('getLastSegment')) {
    function getLastSegment() {
        $uri = service('uri');
        return $uri->getSegment($uri->getTotalSegments());
    }
}