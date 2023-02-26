<?php

function start($update) {
    $user_id = $update->message->chat->id;
    if (db_status::get_status($user_id)) {
        cancel($update);
        return;
    }
    $update->method[0] = 'sendMessage';
    $update->post_fields[0]->chat_id = $user_id;
    $update->post_fields[0]->parse_mode = "HTML";
    $update->post_fields[0]->text = "<b><u>Welcome to Mozilla Common Voice Telegram Bot</u></b> 
Mozilla Common Voice is an open-source initiative to make voice technology more inclusive.
Contributors donate speech data to a public dataset, which anyone can then use to train voice-enabled technology. 
<b><u> Do you consent with our policy?</u></b> 
";

    $keyboard = [
        [
            ['text' => 'Yes👍🏽', 'callback_data' => '1_'], ['text' => 'No👎', 'callback_data' => '0_']
        ]
    ];
    $update->post_fields[0]->reply_markup = json_encode(array(
        'inline_keyboard' => $keyboard,
    ));
}

//
