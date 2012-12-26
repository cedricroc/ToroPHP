<?php

class StatsHandler
{
    function get_xhr(ToroPHP_Request $request)
    {
        echo json_encode(get_stats());
    }
}