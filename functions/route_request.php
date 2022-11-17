<?php

function send_error_message($update, $text) {
    $update->method[0] = 'sendMessage';
    // $update->post_fields[1] = new \stdClass();
    $update->post_fields[0]->chat_id = $update->message->chat->id;
    $update->post_fields[0]->text = $text;
}

function sendss($update) {
//    $update->method[0] = 'sendMessage';
//    $update->post_fields[0]->chat_id = $update->message->chat->id;
//    
//     $update->post_fields[0]->text = print_r(get_room_info(4),true);
    hotelForward($update, 11);
//      $keyboard = [
//        [
//            ['text' => 'TRY ', 'url' => 'https://t.me/MarefiaSubmissionBot?start=123'],
//        ],];
//      $update->post_fields[0]->reply_markup = json_encode(array(
//        'inline_keyboard' => $keyboard,
//    ));
////This thing goes to the start command with a parameter of 3, so there should be 2 cases of start (one for with pars and one normal)
// print_r($update->parameters[0],TRUE) ;      
}

///
function route_request($update) {
    if (isset($update->callback_query)) { //move to the end with the stat check 
        if (get_status($user_id)) {
            cancel($update); //
            return;
        }
        perform_callback($update);
        return;
    }
    // $idx = $update->message->chat->id;
    // Is it a command?
    if (isset($update->message->entities[0]) && $update->message->entities[0]->type == 'bot_command') {
        $user_id = $update->message->chat->id;
        if (get_status($user_id)) {
            cancel($update); //
            return;
        }
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
    } else {

        $chatid = $update->message->chat->id;
        $result = get_status($chatid);
       // route_texts($result, $update);
    }
}
