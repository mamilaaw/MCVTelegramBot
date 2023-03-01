<?php
function route_voice($update){
if ($update->message->voice->mime_type == "audio/ogg") {
        $id = $update->message->voice->file_id;
        $update->method[0] = 'getFile';
        $update->post_fields[0]->file_id = $id;
        $res = send_response($update); //json encoded result
        $a = json_decode($res);
        $b = json_decode($a[0]); //
        $file_path = $b->result->file_path; // the temp file path on telegram
        $full_file_path = "https://api.telegram.org/file/bot" . BOT_TOKEN . "/$file_path";
        
        $sentence_id = "000001bd08fb03e61166197ff69755e4c0c064ae71b021355eb3807eae9f363";
        $authorization = "Basic ". "NDIyYjlmOTgtMWNlZS00ZWFlLWI0ZDItNTYzM2MxNWFjNDQyOjZjZTczM2U1ZGJkNjgyZDViOWU2ZTQ5MmRjNjAxYWY3NWI3ZDMxYzQ=";
        
 
  
//$client = new GuzzleHttp\Client();
//// Prepare Request
//$request = $client->request('POST', 'https://dev.voice.mozit.cloud/);
//
//// Send Request
//$response = $client->send($request, [
//    'headers' => [
//        'Content-Type' => 'audio/ogg; codecs=opus',
//        'sentence_id' => $sentence_id,
//        'source'=> 'telegram',
//        'Authorization'=> $authorization,
//        'data-binary' => $full_file_path,
//        
//    ],   
//]);
//
//// Read Response
//$response_body = (string)$response->getBody();
  
  
    $update->method[0] = 'sendMessage';
    $update->post_fields[0]->chat_id = $update->message->chat->id;
    $update->post_fields[0]->text =$full_file_path;
  
//        $voice_id = "This Should Be Fixed".$response_body;
//        $update->method[0] = 'sendVoice';
//        $update->post_fields[0]->chat_id = $update->message->chat->id;
//        $update->post_fields[0]->voice = $id;
//        $keyboard = [
//            [
//                ['text' => 'Yes👍🏽', 'callback_data' => '2_' . $voice_id], ['text' => 'No👎', 'callback_data' => '3_' . $voice_id]
//            ]
//        ];
//        $update->post_fields[0]->reply_markup = json_encode(array(
//            'inline_keyboard' => $keyboard,
//        ));
        return;
    }

}