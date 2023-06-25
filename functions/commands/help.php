     <?php
//
function help($update) {
    $user_id = $update->message->chat->id;
    if (db_status::get_status($user_id)){
        cancel($update);
        return;
    }
    $update->method[0] = 'sendMessage';
    $update->post_fields[0]->chat_id = $user_id;
    $update->post_fields[0]->parse_mode = "HTML";
    $update->post_fields[0]->text = "Voice is natural, voice is human. That’s why we’re excited about creating usable voice technology for our machines. "
            . "But to create voice systems, developers need an extremely large amount of voice data. "
            . "Most of the data used by large companies isn’t available to the majority of people. We think that stifles innovation. "
            . "So we’ve launched Common Voice, a project to help make voice recognition open and accessible to everyone."
            . "To use this bot please use the commands found on the menu section which are :
 <b>/speak : This command allows you to record your voice and contribute it to the Mozilla Common Voice dataset </b> 
 <b>/listen : This command allows you to listen to recordings of other people's voices that have been contributed to the Mozilla Common Voice dataset. </b> 
 ";

    $keyboard = [
        [
            ['text' => 'Why common voice? ', 'callback_data' => 'Why'],
        ],
        [
            ['text' => 'Visit the web app...', 'url' => 'https://commonvoice.mozilla.org/']
        ],
        [
            ['text' => 'Sign up for MCV network here...', 'url' => 'https://commonvoice.mozilla.org/login']
        ],
    ];
    $update->post_fields[0]->reply_markup = json_encode(array(
        'inline_keyboard' => $keyboard,
    ));
}
