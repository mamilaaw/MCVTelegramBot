<?php

include_once 'constants.php';
// Database functions/
require_once 'functions/database/db_connection.php';
require_once 'functions/database/db_status.php';
require_once 'functions/database/db_user.php';


require __DIR__ . "/vendor/autoload.php";

//general cmds
include_once 'functions/commands/route_command.php';
include_once 'functions/commands/start.php';
include_once 'functions/commands/speak.php';
include_once 'functions/commands/listen.php';
include_once 'functions/commands/help.php';
include_once 'functions/commands/cancel.php';

// Voice and Voice handlers
include_once 'functions/voices/route_voice.php';

// moving it to a more general place
include_once 'functions/stateless_text.php'; 



//  To route all the requested call backs
include_once 'functions/callbacks/route_callback.php';
include_once 'functions/callbacks/listen_processor.php';

include_once 'functions/route_request.php';
include_once 'functions/send_response.php';

// Grab the JSON input stream from Telegram, convert it to an object
$update = json_decode(file_get_contents('php://input'));
// Initialize two variables used to respond to Telegram.
// (Arrays allow for multiple responses to be sent to Telegram.) 
//
$update->method = array();
$update->post_fields = array();
// There will always be at least one response
$update->post_fields[0] = new \stdClass();


route_request($update);

send_response($update);

