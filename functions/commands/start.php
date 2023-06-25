<?php

function start($update) {
    $user_id = $update->message->chat->id; //
    if (db_status::get_status($user_id)) {
        cancel($update);
        return;
    }
    if (!db_user::get_user($user_id) || db_user::get_user($user_id)["consent"] == 0 ) {
        // to check if the user is already on the database or not
        //Here the user is not on the database so we are registering it as a first time user
        $db = new db_user();
        $res = $db->new_user($user_id);
        $update->method[0] = 'sendMessage';
        $update->post_fields[0]->chat_id = $user_id;
        $update->post_fields[0]->parse_mode = "HTML";
        $update->post_fields[0]->text = "<b><u>Welcome to Mozilla Common Voice Telegram Bot</u></b> 
Mozilla Common Voice is an open-source initiative to make voice technology more inclusive.
Contributors donate speech data to a public dataset, which anyone can then use to train voice-enabled technology. 
<b><u> Do you consent with our policy?</u> Please note that once you consent you can not take back the consent on this bot.</b> 
";

        $keyboard = [
            [
                ['text' => 'Yes👍🏽', 'callback_data' => 'consent'], ['text' => 'No👎', 'callback_data' => 'not_consent'] ////
            ]
        ];
        $update->post_fields[0]->reply_markup = json_encode(array(
            'inline_keyboard' => $keyboard,
        ));
        return;
    } else {
        $update->method[0] = 'sendMessage';
        $update->post_fields[0]->chat_id = $user_id;
        $update->post_fields[0]->parse_mode = "HTML";
        $update->post_fields[0]->text = "<b><u>Welcome to Mozilla Common Voice Telegram Bot</u></b> 
Mozilla Common Voice is an open-source initiative to make voice technology more inclusive.
Contributors donate speech data to a public dataset, which anyone can then use to train voice-enabled technology. Please use /help
command to learn more on how to use this bot.";
    }
}

//
