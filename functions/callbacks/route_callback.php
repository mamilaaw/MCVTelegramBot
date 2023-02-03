<?php
//this needs to be a little more organization
function done_callback($update) {
    $update->post_fields[1] = new \stdClass();
    $update->method[1] = 'answerCallbackQuery';
    $update->post_fields[1]->callback_query_id = $update->callback_query->id;
}

function route_callback($update) {
    $update->method[0] = 'sendMessage';
    $update->post_fields[0]->chat_id = $update->callback_query->message->chat->id;
    //
    //$update->post_fields[0]->text = 'Wellcome to Arkebe Suk, Selling point of contact. ".';
    switch ($update->callback_query->data) {
        case 'why_MCV':
            $update->post_fields[0]->text = 'Because Mozilla is the best...😉';
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
