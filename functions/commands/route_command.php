<?php
// A function to route all commands starting with "/"
function route_command($update){
$update->parameters = array();
        $update->command[0] = substr($update->message->text, 0, $update->message->entities[0]->length);
        $update->parameters[0] = substr($update->message->text, $update->message->entities[0]->length + 1);

        switch ($update->command[0]) {
             case ('/start'):
                start($update);
                break;
            case ('/speak'):
                speak($update);
                break;
           
            case ('/listen'):
                listen($update);
                break;
            case ('/help'):
                help($update);
                break;
            case("/sss"):
                sendss($update);
                break;

            case ('/cancel'):
                cancel($update);
                break;

            default:
                unstructured_cmd($update);
                break;
        }
}