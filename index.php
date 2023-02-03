
<pre><?php
////
require __DIR__."/vendor/autoload.php";

$client = new GuzzleHttp\Client();

$url = "https://dev.voice.mozit.cloud/api/v1/en/clips?count=1";

$response = $client -> request("GET",$url);

var_dump((string)$response ->getBody("sentence"));

//require 'vendor/autoload.php';//";
//
//$log = new Monolog\Logger('name');
//$log->pushHandler(new Monolog\Handler\StreamHandler('app.log', Monolog\Logger::WARNING));
//$log->warning('Foo');

echo "hello world";//?></pre>