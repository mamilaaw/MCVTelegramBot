<?php

function speak($user_id) {
 
    global $update;
    
    //Grab the voice from Mozilla API and send it to the Client
    $url = COMMON_VOICE_API_URL."/en/sentences?count=1";
    $client = new GuzzleHttp\Client();
    $response = $client->request("GET", $url);
    $data = json_decode($response->getBody()->getContents(), true)[0];
    $sentence = $data["text"];
    $sentence_id = $data["id"]; //Probably use this to set status on the DB like marefia 
   
    if (get_status($user_id)){
        cancel($update);//
        return;
    }
    
    $update->method[0] = 'sendMessage';
    $update->post_fields[0]->chat_id = $user_id;
    //reply_to_message_id
    $update->post_fields[0]->text = " \n Please speak this sentence: ".$sentence;//print_r($data,true);//print_r($dec[1]->text,true);
    $update->post_fields[0]->reply_markup = json_encode(array(
        'force_reply' => true,
    ));
    ///
}

