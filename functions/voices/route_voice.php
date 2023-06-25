<?php

function route_voice($update) {
    $user_id = $update->message->chat->id;
    $status = db_status::get_status($user_id);
    if ($status ["type"] !== "sentence_id") {
        cancel($update, $status);
        return;
    }

    $user_db = db_user::get_user("$user_id");
    if ($update->message->voice->mime_type == "audio/ogg") {

        $file_id = $update->message->voice->file_id;
        
        $update->method[0] = 'getFile';
        $update->post_fields[0]->file_id = $file_id ;
        $result = send_response($update); //json encoded result
       
        $a = json_decode($result);
        $b = json_decode($a[0]); //
        $file_path = $b->result->file_path; // the temp file path on telegram
        $full_file_path = "https://api.telegram.org/file/bot" . BOT_TOKEN . "/$file_path"; // download to local server and delete after usage

        $sentence_id = $status["current_stat"];
        $authorization = "Basic " . $user_db["authorization"];

        $temp_file = tempnam(sys_get_temp_dir(), 'audio');
        rename($temp_file, $temp_file .= '.ogg');
        $del = copy($full_file_path, $temp_file);



        $client = new \GuzzleHttp\Client();

// Build POST request
        $request = new \GuzzleHttp\Psr7\Request(
                'POST',
                COMMON_VOICE_API_URL.'/en/clips',
                [
            'Authorization' => $authorization,
            'Content-Type' => 'audio/ogg; codecs=opus',
            'sentence_id' => $sentence_id,
            'source' => 'telegram',
                ],
                fopen($temp_file, 'r')
        );
//

        $response = $client->send($request);

//        
        $voice_id = "File id here";
        $update->method[0] = 'sendVoice';
        $update->post_fields[0]->chat_id = $user_id;
        $update->post_fields[0]->voice = $file_id ;
        $keyboard = [
            [
                ['text' => 'Yes👍🏽', 'callback_data' => '2_' . $voice_id], ['text' => 'No👎', 'callback_data' => '3_' . $voice_id]
            ]
        ];
        $update->post_fields[0]->reply_markup = json_encode(array(
            'inline_keyboard' => $keyboard,
        ));
        
        unlink($temp_file);

        db_status::del_status($user_id); //
        return;
    }
}
