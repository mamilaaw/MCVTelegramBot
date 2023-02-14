<?php
//this needs to be a little more organization
function done_callback($update) {
    $update->post_fields[1] = new \stdClass();
    $update->method[1] = 'answerCallbackQuery';
    $update->post_fields[1]->callback_query_id = $update->callback_query->id;
}

function route_callback($update) {
    $user_id = $update->callback_query->from->id;
    $update->method[0] = 'sendMessage';
    $update->post_fields[0]->chat_id = $user_id;
    //
   
    $data = $update->callback_query->data;
    
    switch ($data) {
        case (bool)preg_match( '/[0-1]+_[0-9A-Za-z]+/i', $data) :
            $update->post_fields[0]->text = 'Listen working or so...'.$update->callback_query->data;
            // do a callback processor here;
            done_callback($update);
            send_response($update);
            listen($user_id);
            break;
         case (bool)preg_match( '/[2-3]+_[0-9A-Za-z]+/i', $data) :
            $update->post_fields[0]->text = 'Speak is also working'.$update->callback_query->data;
            // do a callback processor here;
            done_callback($update);
            send_response($update);
            speak($user_id);
            break;
        case 'Why':
            $update->post_fields[0]->text = 'Because Mozilla is the best...😉';
            done_callback($update);
            break;
        case 'General':
            $update->post_fields[0]->text = 'For general inquires contact at @superevot.';
            done_callback($update);
            break;
        default :
            $update->post_fields[0]->text = $update->callback_query->data. 'I did not understand your request.';
            done_callback($update);
            break;
    }
}
