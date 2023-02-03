<?php

function speak($update) {
    $userid = $update->message->chat->id;
    if (get_status($userid)){
        cancel($update);
        return;
    }
    $update->method[0] = 'sendMessage';
    $update->post_fields[0]->chat_id = $update->message->chat->id;
    
    $url = "https://commonvoice.mozilla.org/api/v1/en/sentences?count=2";
            
    $json = file_get_contents($url);
    $dec= json_decode($json);
    //reply_to_message_id
    $update->post_fields[0]->text = $dec[1]->text;//print_r($dec[1]->text,true);
    $update->post_fields[0]->reply_markup = json_encode(array(
        'force_reply' => true,
    ));
    ///
}

