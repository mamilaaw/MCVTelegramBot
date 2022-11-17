<?php

function start($update) {
        $userid = $update->message->chat->id;
    if (get_status($userid)){
        cancel($update);
        return;
    }
    $update->method[0] = 'sendMessage';
    $update->post_fields[0]->chat_id = $update->message->chat->id;
    $update->post_fields[0]->parse_mode = "HTML";
//    $update->post_fields[0]->text = '<u><b>Wellcome to Marefia Submission Bot.</u></b> You can earn money by working on your free time
//            We are pleased to have you work with us. Please read documents in /help command to start.';

   $update->post_fields[0]->text = "<b><u>Welcome to Mozilla Common Voice Telegram Bot</u></b> 
Mozilla Common Voice is an open-source initiative to make voice technology more inclusive.
Contributors donate speech data to a public dataset, which anyone can then use to train voice-enabled technology. 
Please read documents in /help command to get started.
";
}//
