<?php

require("../../bootstrap.php");


class HelloHandler
{
    public function get(ToroPHP_Request $request = null)
    {
      echo "Hello, world";
    }
    
    public function get_xhr()
    {
        echo 'Test OK XHR';
    }
}

class NotFound
{
    public function get()
    {
        echo 'NOT FOUND !';
    }
}


$routes = array(
    "/" => "HelloHandler",
    "404" => "NotFound",
);

$router = new ToroPHP_Toro($routes, new ToroPHP_Request());
$router->serve();