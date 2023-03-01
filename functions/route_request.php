<?php

function send_error_message($update, $text) {
    $update->method[0] = 'sendMessage';
    // $update->post_fields[1] = new \stdClass();
    $update->post_fields[0]->chat_id = $update->message->chat->id;
    $update->post_fields[0]->text = $text;
}

///
function route_request($update) {
    $user_id = isset($update->message->chat->id) ? $update->message->chat->id : $update->callback_query->from->id;

// tHIS IS FOR DEV PURPOSE ONLY    
    if (!in_array($user_id, ADMIN_ID)) {
        $update->method[0] = 'sendMessage';
        $update->post_fields[0]->chat_id = $user_id;
        $update->post_fields[0]->text = 'Not launched yet! Please contact @supereveot for more info.';
        return;
    }
    if (db_status::get_status($user_id)) {
        cancel($update); //
        return;
    }
    if (isset($update->callback_query)) {
        route_callback($update);
        return;
    } else if (isset($update->message->entities[0]) && $update->message->entities[0]->type == 'bot_command') {
        route_command($update);
        return;
    } else if ($update->message->voice->mime_type == "audio/ogg") {
        route_voice($update);
    } else {
        //$result = db_status::get_status($user_id);
        stateless_text($update);
        //route_texts($result, $update);
    }
}
