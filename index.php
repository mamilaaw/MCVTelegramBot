
<pre><?php
////
    require __DIR__ . "/vendor/autoload.php";

    $sentence_id = "000001bd08fb03e61166197ff69755e4c0c064ae71b021355eb3807eae9f363";
    $authorization = "Basic " . "NDIyYjlmOTgtMWNlZS00ZWFlLWI0ZDItNTYzM2MxNWFjNDQyOjZjZTczM2U1ZGJkNjgyZDViOWU2ZTQ5MmRjNjAxYWY3NWI3ZDMxYzQ=";
    $full_file_path= "https://api.telegram.org/file/bot5769796666:AAG1yHG4ujMTgV19OqPpacWMc6_6NNRB6VA/voice/file_35.oga";
    $client = new GuzzleHttp\Client();
// Prepare Request
    $request = $client->request('POST', 'https://dev.voice.mozit.cloud/en/speak');
    $client->post();
// Send Request
    $response = $client->send($request, [
        'headers' => [
            'Content-Type' => 'audio/ogg; codecs=opus',
            'sentence_id' => $sentence_id,
            'source' => 'telegram',
            'Authorization' => $authorization,
            'data-binary' => $full_file_path,
        ],
    ]);

// Read Response
    $response_body = (string) $response->getBody();
    
    var_dump($response_body);
    ?>
<audio controls>
    <source src=<?php echo $audioSrc; ?> type="audio/mpeg">
Your browser does not support the audio element.
</audio>

        <?php
//require 'vendor/autoload.php';//";
//
//$log = new Monolog\Logger('name');
//$log->pushHandler(new Monolog\Handler\StreamHandler('app.log', Monolog\Logger::WARNING));
//$log->warning('Foo');


    echo "\n";
    echo $response->getStatusCode(); // 200
    echo $response->getReasonPhrase(); // OK
    echo $response->getProtocolVersion(); // 1.1
//e$response->getBody();
    echo "hello world"; //
    ?></pre>