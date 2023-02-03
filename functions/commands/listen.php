<?php


function listen($update) {
    $userid = $update->message->chat->id;
    if (get_status($userid)){
        cancel($update);
        return;
    }
    $update->method[0] = 'sendVoice';
    $update->post_fields[0]->chat_id = $update->message->chat->id;
      $keyboard = [
        [
            ['text' => 'Yes👍🏽', 'callback_data' => 'Yes'], ['text' => 'No👎', 'callback_data' => 'No']
        ]
    ];
    $update->post_fields[0]->reply_markup = json_encode(array(
        'inline_keyboard' => $keyboard,
    ));
    $url = "https://commonvoice.mozilla.org/api/v1/en/clips?count=1";
            
    $json = file_get_contents($url);
    
   $dec= json_decode($json);
    
   $update->post_fields[0]-> voice = $dec[0]->audioSrc;//"https://download.samplelib.com/mp3/sample-3s.mp3";
   $update->post_fields[0]-> caption = $dec[0]->sentence->text. "\n Voice Id: ". $dec[0]->id
           ."\n Sentence Id: ".$dec[0]->sentence->id;//$dec[0]->sentence->text." ";//. $dec[0]->audioSrc;
   
 
  
    
    ///
}

