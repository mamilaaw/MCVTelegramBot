<?php

//All messages from the telegram bot passes through this function
function route_request($update) {

    if (isset($update->callback_query)) {
        route_callback($update);
        return;
    }

    $user_id = isset($update->message->chat->id) ? $update->message->chat->id : $update->callback_query->from->id;
    $user_db = db_user::get_user($user_id);
    if ($user_db["consent"] !== "1") {
        start($update);
        return; ///
        //cancel($update);//
    }
// tHIS IS FOR DEV PURPOSE ONLY    
    if (!in_array($user_id, ADMIN_ID)) {
        $update->method[0] = 'sendMessage';
        $update->post_fields[0]->chat_id = $user_id;
        $update->post_fields[0]->text = 'Not launched yet! Please contact @supereveot for more info.';
        return;
    }

    if (isset($update->message->entities[0]) && $update->message->entities[0]->type == 'bot_command') {
        route_command($update);
        return;
    } else if ($update->message->voice->mime_type == "audio/ogg") {
        route_voice($update);
    } else {
        stateless_text($update);
    }
}
