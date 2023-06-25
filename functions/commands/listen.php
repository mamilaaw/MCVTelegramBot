<?php

function listen($user_id) {//
    
    
    // 
    global $update;
    
    
    //Get the voice from mozilla common voice api...
    $client = new GuzzleHttp\Client();
    $url = COMMON_VOICE_API_URL."/".LANGUAGE."/clips?count=10";
    $response = $client->request("GET", $url);
    // Send random voice from the response everytime.
    $rand = rand(0,9);
    $data = json_decode($response->getBody()->getContents(), true)[$rand];
    $sentence = "Sentence : " . $data["sentence"]["text"];
    $sentence_id = $data["sentence"]["id"];
    $voice_id = $data["id"];
    $audioSrc = $data["audioSrc"];
  
    
    db_status::set_status($user_id, "voice_id", $voice_id);
 
    $update->method[0] = 'sendVoice';
    $update->post_fields[0]->chat_id = $user_id;
    $keyboard = [
        [
            ['text' => 'Yes👍🏽', 'callback_data' => '1_' . $voice_id], ['text' => 'No👎', 'callback_data' => '0_' . $voice_id]
        ]
    ];
    $update->post_fields[0]->reply_markup = json_encode(array(
        'inline_keyboard' => $keyboard,
    ));
    $update->post_fields[0]->voice = $audioSrc; 
    $update->post_fields[0]->caption = $sentence ; //$dec[0]->sentence->text." ";//. $dec[0]->audioSrc;
    ///
    return;
     
}
