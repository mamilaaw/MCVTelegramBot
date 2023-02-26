
<pre><?php
////
    require __DIR__ . "/vendor/autoload.php";

    $client = new GuzzleHttp\Client();

    $url = "https://dev.voice.mozit.cloud/api/v1/en/clips?count=1";

    $response = $client->request("GET", $url);
    
    include './functions/database/db_connection.php';
    
    include './functions/database/db_user.php';
    //
//  
$user = new db_user();
$res= $user->new_user(22233);
print_r(db_user::get_user(22233));
    ?>
<audio controls>
    <source src=<?php echo $audioSrc;?> type="audio/mpeg">
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