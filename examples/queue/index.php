<?php


require("../../bootstrap.php");

require("handlers/dashboard_handler.php");
require("handlers/receive_handler.php");
require("handlers/send_handler.php");
require("handlers/stats_handler.php");
require("lib/mysql.php");
require("lib/queries.php");

ToroPHP_Hook::add("404", function() {
    echo "Not found";
});

$routes = array(
    "/"         => "DashboardHandler",
    "/send"     => "SendHandler",
    "/receive"  => "ReceiveHandler",
    "/stats"    => "StatsHandler"
);

$router = new ToroPHP_Toro($routes, new ToroPHP_Request());
$router->serve();
