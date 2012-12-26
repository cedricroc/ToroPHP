<?php

class ReceiveHandler
{
    function get_xhr(ToroPHP_Request $request)
    {
        echo json_encode(array("payload" => receive_payload()));
    }
}