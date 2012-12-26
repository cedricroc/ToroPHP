<?php

class SendHandler
{
    function post(ToroPHP_Request $request)
    {
        $payload = $request->getValue('post', 'payload');
        
        if (isset($payload) && strlen(trim($payload)) > 0) {
            send_payload($payload);
        }
        
        header("Location: /examples/queue/");
    }
}