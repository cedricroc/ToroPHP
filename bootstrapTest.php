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

class TestHandle
{
    function get()
    {
        echo 'Test OK';
    }
    
    function get_xhr()
    {
        echo 'Test OK XHR';
    }
}

class NotFound
{
    function get()
    {
        echo '404 NOT FOUND';
    }
}

require(dirname(__FILE__) . '/bootstrap.php');