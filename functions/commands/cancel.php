<?php

// to cancel current commands
function cancel($update) {
    $update->method[0] = 'sendMessage';
    $update->post_fields[0]->chat_id = $update->message->chat->id;
    $update->post_fields[0]->text = 'Cancelling current operation...';
    $update->post_fields[0]->reply_markup = json_encode(array('remove_keyboard' => true));
    $userid = $update->message->chat->id;
    $result = db_status::get_status($userid);
    
}
