     <?php
//
function help($update) {
    $userid = $update->message->chat->id;
    if (get_status($userid)){
        cancel($update);
        return;
    }
    $update->method[0] = 'sendMessage';
    $update->post_fields[0]->chat_id = $update->message->chat->id;
    $update->post_fields[0]->text = "Voice is natural, voice is human. That’s why we’re excited about creating usable voice technology for our machines.But to create voice systems, developers need an extremely large amount of voice data. Most of the data used by large companies isn’t available to the majority of people. We think that stifles innovation. So we’ve launched Common Voice, a project to help make voice recognition open and accessible to everyone.";

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
