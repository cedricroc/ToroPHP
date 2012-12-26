<?php
/**
 * ToroPHP (https://github.com/cedricroc/ToroPHP)
 * 
 * Original project https://github.com/anandkunal/ToroPHP
 * 
 * ToroPHP is a small router framework.
 *
 * @link      https://github.com/cedricroc/ToroPHP
 * @license   MIT
 * 
 * @author Berker Peksag, Martin Bean, Robbie Coleman, and John Kurkowski for bug fixes and patches
 * @author Danillo César de O. Melo for ToroHook
 * @author Jason Mooberry for code optimizations and feedback
 * @author Kunal Anand
 * @author Cédric ROCHART <cedric.rochart@gmail.com>
 */


if (!function_exists('_isset')) {

    function _isset($val)
    {
        return isset($val);
    }
}

if (!function_exists('_empty')) {

    function _empty($val)
    {
        return empty($val);
    }
}