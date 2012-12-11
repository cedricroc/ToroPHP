<?php

require("../../bootstrap.php");


class HelloHandler
{
    function get(ToroRequest $request = null)
    {
      var_dump($request->getDatas());
      echo "Hello, world";
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
        echo "DA NOT FOUND !";
    }
}


$routes = array(
    "/" => "HelloHandler",
    "/:alpha/saumon/:number/" => "HelloHandler",
    "/:number/" => "HelloHandler",
    "404" => "NotFound",
);

$server = array('REQUEST_METHOD'         => 'GET',
                'PATH_INFO'              => '/',
                'HTTP_X_REQUESTED_WITH'  => 'XMLHttpRequest',
            );

$request = new ToroRequest();
$router = new Toro($routes, $request);
$router->serve();