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
        case (bool) preg_match('/[0-1]+_[0-9A-Za-z]+/i', $data) :
            // For listen vote 
            $response = listen_processor($data, $user_id);
            $update->post_fields[0]->text = "Thanks, here goes another one...";
            done_callback($update);
            send_response($update);
            listen($user_id);
            break;
        case (bool) preg_match('/[2-3]+_[0-9A-Za-z]+/i', $data) :
            //For Speak
            $update->post_fields[0]->text = 'Thanks for confirmation!'.$data; // To be fixed in the next release
            // do a callback processor here;  
            done_callback($update);
            send_response($update);
            speak($user_id);
            break;
        case 'consent':
            $update->post_fields[0]->text = 'You did consent. Please use the /help command to get more info on how to use this bot. Thanks!';
            db_user::consent_user($user_id);
            done_callback($update);
            break;
        case 'not_consent':
            if (db_user::get_user($user_id)["consent"] == "1") {
                $update->post_fields[0]->text = 'You have already consented to use our service.';
                done_callback($update);
            } else {
                $update->post_fields[0]->text = 'You can not use this bot without consenting. Please try again with /start.';
                done_callback($update);
            }

            break;
        case 'Why':
            $update->post_fields[0]->text = 'Mozilla Common Voice in Telegram bot is a valuable tool for improving speech recognition in low-bandwidth areas. By reducing data usage, increasing participation, and improving speech recognition, the bot can help to make communication more accessible to people in these areas.';
            done_callback($update);
            break;
        case 'General':
            $update->post_fields[0]->text = 'For general inquires contact at @superevot.';
            done_callback($update);
            break;
        default :
            $update->post_fields[0]->text = $update->callback_query->data . 'I did not understand your request.';
            done_callback($update);
            break;
    }
}
