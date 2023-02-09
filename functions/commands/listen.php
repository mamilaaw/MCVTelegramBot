<?php

function listen($update) {//
    //$url = "https://dev.voice.mozit.cloud/api/v1/en/clips?count=1";
    //$json = file_get_contents($url);
    //$dec = json_decode($json);
    //$sentence = $dec[0]->sentence->id;
    // $sentence_id = $dec[0]->sentence->id;
    // $voice_id = $dec[0]->id;
    // $audioSrc = $dec[0]->audioSrc;
    $client = new GuzzleHttp\Client();

    $url = "https://dev.voice.mozit.cloud/api/v1/en/clips?count=1";

    $response = $client->request("GET", $url);
//////print_r($response->getHeader("ETag")[0]);
    $data = json_decode($response->getBody()->getContents(), true)[0];
    $sentence = "From Guzzle: " . $data["sentence"]["text"];
    $sentence_id = $data["sentence"]["id"];
    $voice_id = $data["id"];
    $audioSrc = $data["audioSrc"];

    $userid = $update->message->chat->id;

    if (get_status($userid)) {
        cancel($update);
        return;
    }
    $update->method[0] = 'sendVoice';

    $update->post_fields[0]->chat_id = $update->message->chat->id;
    $keyboard = [
        [
            ['text' => 'Yes👍🏽', 'callback_data' => '1_' . $voice_id], ['text' => 'No👎', 'callback_data' => '0_' . $voice_id]
        ]
    ];
    $update->post_fields[0]->reply_markup = json_encode(array(
        'inline_keyboard' => $keyboard,
    ));

    $update->post_fields[0]->voice = $audioSrc; //"https://download.samplelib.com/mp3/sample-3s.mp3";
    $update->post_fields[0]->caption = $sentence . "\n Voice Id: " . $voice_id
            . "\n Sentence Id: " . $sentence_id; //$dec[0]->sentence->text." ";//. $dec[0]->audioSrc;
    ///
}
