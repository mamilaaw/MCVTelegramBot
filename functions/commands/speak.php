<?php

function speak($user_id) {

    global $update;
    
    $user_db = db_user::get_user($user_id);
    if ($user_db["consent"] !== "1") {
        $update->method[0] = 'sendMessage';
        $update->post_fields[0]->chat_id = $user_id; //
        $update->post_fields[0]->text = print_r($user_db, true); ////
        //cancel($update);//
        return;
    }
    //Grab the voice from Mozilla API and send it to the Client
    $url = COMMON_VOICE_API_URL . "/en/sentences?count=1";
    $client = new GuzzleHttp\Client();
    $response = $client->request("GET", $url);
    $data = json_decode($response->getBody()->getContents(), true)[0];
    $sentence = $data["text"];
    $sentence_id = $data["id"]; //Probably use this to set status on the DB like marefia 

    
    
    db_status::set_status($user_id, "sentence_id", $sentence_id);

    $update->method[0] = 'sendMessage';
    $update->post_fields[0]->chat_id = $user_id;
    $update->post_fields[0]->parse_mode = "HTML";
    //reply_to_message_id
    $update->post_fields[0]->text = "Please speak and record this sentence:<b> <u>" . $sentence . "</u></b> "; //print_r($data,true);//print_r($dec[1]->text,true);
    $update->post_fields[0]->reply_markup = json_encode(array(
        'force_reply' => true,
    ));
    ///
}
