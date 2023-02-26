<?php
function stateless_text($update) {
    if ($update->message->voice->mime_type == "audio/ogg") {
        $id = $update->message->voice->file_id;
        $update->method[0] = 'getFile';
        $update->post_fields[0]->file_id = $id;
        $res = send_response($update); //json encoded result
        $a = json_decode($res);
        $b = json_decode($a[0]); //
        $file_path = $b->result->file_path; // the temp file path on telegram
        $full_file_path = "https://api.telegram.org/file/bot" . BOT_TOKEN . "/$file_path";

//        $update->method[0] = 'sendMessage';
//        $update->post_fields[0]->chat_id = $update->message->chat->id;
//        $update->post_fields[0]->text = print_r($full_file_path,true);
        $audioSrc = $full_file_path; //'I did not understand what you said. Please visit /help to use me.';
        $voice_id = "This ShouldBe Fixed";
        $update->method[0] = 'sendVoice';
        //update->post_fields[1] = new \stdClass();
        $update->post_fields[0]->chat_id = $update->message->chat->id;
        $update->post_fields[0]->voice = $id;
        $keyboard = [
            [
                ['text' => 'Yes👍🏽', 'callback_data' => '2_' . $voice_id], ['text' => 'No👎', 'callback_data' => '3_' . $voice_id]
            ]
        ];
        $update->post_fields[0]->reply_markup = json_encode(array(
            'inline_keyboard' => $keyboard,
        ));
        return;
    }
    $update->method[0] = 'sendMessage';
    $update->post_fields[0]->chat_id = $update->message->chat->id;
    $update->post_fields[0]->text = 'I did not understand what you said. Please visit /help to use me.'; //print_r($update, true); //
}
 