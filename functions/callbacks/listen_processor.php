<?php

function listen_processor($data, $user_id) {
    //$data [0] = 1 yes 0 no
    $data = explode("_", $data);
    $voice_id = $data [1];

    $isValid = $data [0] == "1" ? "true" : "false";

    $user_db = db_user::get_user("$user_id");
    $authorization = "Basic " . $user_db["authorization"];

    $client = new \GuzzleHttp\Client();

// Build POST request
    $request = new \GuzzleHttp\Psr7\Request(
            'POST',
            // https://dev.voice.mozit.cloud/api/v1/en/clips/570/votes
            COMMON_VOICE_API_URL . '/' . LANGUAGE . '/clips/' . $voice_id . '/votes',
            [
        'Authorization' => $authorization,
        'Content-Type' => 'application/json; charset=utf-8',
        'source' => 'telegram',
            ],
            '{"isValid":' . $isValid . ',"challenge":null}'
    );
    
    $response = $client->send($request);
    return $response;
}
