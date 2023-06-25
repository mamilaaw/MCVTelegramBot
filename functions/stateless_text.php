<?php
function stateless_text($update) {
    if (db_status::get_status($update->message->chat->id)) {
        cancel($update ,"Another operation was on the way :(");
        return;
    }
    $update->method[0] = 'sendMessage';
    $update->post_fields[0]->chat_id = $update->message->chat->id;
    $update->post_fields[0]->text = 'I did not understand what you said. Please visit /help to use me.'; //print_r($update, true); //
}
 