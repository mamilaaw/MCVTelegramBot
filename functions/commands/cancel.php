<?php

// to cancel current commands
function cancel($update,$default= "Default") {
   
        
    $update->method[0] = 'sendMessage';
    $update->post_fields[0]->chat_id = $update->message->chat->id;
    $update->post_fields[0]->text =print_r($default,true);
    $update->post_fields[0]->reply_markup = json_encode(array('remove_keyboard' => true));
    $userid = $update->message->chat->id;
    $result = db_status::del_status($userid);
    
    return $result;
}
