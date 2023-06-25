<?php

// A function to route all commands starting with "/"
function route_command($update) {
    $update->parameters = array();
    $update->command[0] = substr($update->message->text, 0, $update->message->entities[0]->length);
    $update->parameters[0] = substr($update->message->text, $update->message->entities[0]->length + 1);
    
    if (db_status::get_status($update->message->chat->id)) {
        cancel($update ,"Another operation was on the way :(...please try again.");
        return;
    }
    switch ($update->command[0]) {
        case ('/start'):
            start($update);
            break;
        case ('/speak'):
            speak($update->message->chat->id);
            break;
        case ('/listen'):
            listen($update->message->chat->id);
            break;
        case ('/help'):
            help($update);
            break;
        case ('/cancel'):
            cancel($update);
            break;
        default:
            $update->method[0] = 'sendMessage';
            $update->post_fields[0]->chat_id = $update->message->chat->id;
            $update->post_fields[0]->text = 'Unable to locate your request!';
            break;
    }
}
