<?php
//this needs to be a little more organization
function done_callback($update) {
    $update->post_fields[1] = new \stdClass();
    $update->method[1] = 'answerCallbackQuery';
    $update->post_fields[1]->callback_query_id = $update->callback_query->id;
}

function perform_callback($update) {
    $update->method[0] = 'sendMessage';
    $update->post_fields[0]->chat_id = $update->callback_query->message->chat->id;
    //
    //$update->post_fields[0]->text = 'Wellcome to Arkebe Suk, Selling point of contact. ".';
    switch ($update->callback_query->data) {
        case 'what':
            $update->post_fields[0]->text = 'Marefia is a hotel and room finder based on Telegram. ';
            done_callback($update);
            break;
        case 'what_submit':
            $update->post_fields[0]->text = 'Marefia Submission bot is used to submit hotel and room details for freelancer and accomodation owners ';
            done_callback($update);
            break;
        case 'how':
            $update->post_fields[0]->text = 'Register using /register and we will contact you as soon as we have reviewed your profile.';
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
