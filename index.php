<?php

echo "<h1> Trying out post requestss</h1>";
/* API URL */
$url = 'https://httpbin.org/anything';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);

$headers = [
    'Content-Type:application/json',
    'App-Key: 123456',
    'Sentence_id: 123456',
    'user_id: 123456',
    'App-Secret: 123456MM',
    'Source: Telegram Bot'];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$data_array = [
    'isValid'=> true ,       // 
    'challenge' => 'Some Value'
    ];
$data = http_build_query($data_array);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);


curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

/* execute request */
$result = curl_exec($ch);

if ($e = curl_error($ch)) {
    echo $e;
} else {
    echo "<pre>";
    print_r(json_decode($result));
    echo "</pre>";
}


/* close cURL resource */
curl_close($ch);
