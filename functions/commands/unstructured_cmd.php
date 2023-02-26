<?php

function unstructured_cmd($update) {
    $userid = $update->message->chat->id;

    $update->method[0] = 'sendMessage';
    $update->post_fields[0]->chat_id = $userid;
    $update->post_fields[0]->text = 'Searching for your request...';
    if ($userid !== ADMIN_ID) {
        $update->post_fields[1] = new \stdClass();
        $update->method[1] = 'sendMessage';
        $update->post_fields[1]->chat_id = $userid;
        $update->post_fields[1]->text = 'Can not complete your request.';
        return;
    }
    //pending($update);
    $command = $update->command[0];
    $target = explode("_", $command); //target[0] -> accepthot or deletehot || acceptreg deletereg
    if ( isset($target[1])&& !is_numeric($target[1])) { 
        $update->post_fields[1] = new \stdClass();
        $update->method[1] = 'sendMessage';
        $update->post_fields[1]->chat_id = $userid;
        $update->post_fields[1]->text = 'Please insert a valid query.';
        return;
    }//
    send_response($update); // not to crash with the function requests.
    
    switch ($target[0]):
        case("/pending"):
            pending_registration($update);
            break;
        case("/accepthot"):
            $res = accept_hotel($target[1], $update);
            if($res==false){
            $update->method[0] = 'sendMessage';
            $update->post_fields[0]->chat_id = ADMIN_ID;
            $update->post_fields[0]->text = 'Dear ADMIN: ' . $target[1] ." is already accepted or not registered!";
            break;
            }
            $payment = add_hotel_acceptance($res["hotel"]["user_id"]);
            if ($res["query"]) {
                //$update->post_fields[1] = new \stdClass();
                $update->method[0] = 'sendMessage';
                $update->post_fields[0]->chat_id = ADMIN_ID;
                $update->post_fields[0]->text = 'Dear ADMIN: ' . $target[1] . " " . $res["hotel"]["hotel_name"] . " is successfully accepted!";

                $update->post_fields[1] = new \stdClass();
                $update->method[1] = 'sendMessage';
                $update->post_fields[1]->chat_id = $res["hotel"]["user_id"];
                
                $update->post_fields[1]->text = $res["hotel"]["hotel_name"] . " is successfully accepted!"
                        . " You have: ". get_freelancer_info($res["hotel"]["user_id"])['payment'] . " hotels payment pending.";
                //add acceptance for free lancer and notify how much acceptance he/she have
            }
            break;
        case("/posthotel"):
            post_hotel($target[1], $update);
            break;
        case ("/postroom"):
            post_room($target[1], $update);
            break;
        case("/deletehot"):
             $update->method[0] = 'sendMessage';
            $update->post_fields[0]->chat_id = $update->message->chat->id;
            $update->post_fields[0]->text = 'Feature not active yet!';
            break;
        case("/acceptreg"):
            $res = accept_freelancer_registration($target[1]);
             if ($res["query"]) {
                //$update->post_fields[1] = new \stdClass();
                $update->method[0] = 'sendMessage';
                $update->post_fields[0]->chat_id = ADMIN_ID;
                $update->post_fields[0]->text = 'Dear ADMIN: ' . $target[1] . " " . $res["freelancer"]["name"] . " is successfully accepted!";

                $update->post_fields[1] = new \stdClass();
                $update->method[1] = 'sendMessage';
                $update->post_fields[1]->chat_id =  $res["freelancer"]["userid"] ;
                
                $update->post_fields[1]->text = "Your application is successfully accepted. You can now start submitting rooms and hotels and earn money. To start submitting use /submit_hotel command.Please read our terms and standards before submitting a hotel. Thanks!";
                //add acceptance for free lancer and notify how much acceptance he/she have
            }
            break;
        case("/deletereg"):
            $res = delete_freelancer_registration($target[1]);
             if ($res["query"]) {
                //$update->post_fields[1] = new \stdClass();
                $update->method[0] = 'sendMessage';
                $update->post_fields[0]->chat_id = ADMIN_ID;
                $update->post_fields[0]->text = 'Dear ADMIN: ' . $target[1] . " " . $res["freelancer"]["name"] . " is successfully deleted!";

                $update->post_fields[1] = new \stdClass();
                $update->method[1] = 'sendMessage';
                $update->post_fields[1]->chat_id =  $res["freelancer"]["userid"] ;
                
                $update->post_fields[1]->text = "Your application has failed. Please contact @superevot for more info. Thanks!";
                //add acceptance for free lancer and notify how much acceptance he/she have
            }
            break;
        default :
            $update->method[0] = 'sendMessage';
            //$update->post_fields[0] = new \stdClass();
            $update->post_fields[0]->chat_id = $update->message->chat->id;
            $update->post_fields[0]->text = 'Unable to find your request.';
            break;
    endswitch;
}
