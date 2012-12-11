<?php


if (!function_exists('_isset')) {

    function _isset($val) { return isset($val); }
}

if (!function_exists('_empty')) {

    function _empty($val) { return empty($val); }
}