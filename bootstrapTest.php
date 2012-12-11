<?php

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