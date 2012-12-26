<?php

class DashboardHandler
{
    function get(ToroPHP_Request $request)
    {
        $stats = get_stats();
        include("views/dashboard.php");
    }
}