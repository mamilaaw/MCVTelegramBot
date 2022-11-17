<?php

// to cancel current commands
function cancel($update) {
    $update->method[0] = 'sendMessage';
    $update->post_fields[0]->chat_id = $update->message->chat->id;
    $update->post_fields[0]->text = 'Cancelling current operation...';
    $update->post_fields[0]->reply_markup = json_encode(array('remove_keyboard' => true));
    $userid = $update->message->chat->id;
    $result = get_status($userid);
    if ($result["type"] == "reg") {
        del_status($userid);
        delete_freelancer($userid);
        $update->method[1] = 'sendMessage';
        $update->post_fields[1] = new \stdClass();
        $update->post_fields[1]->chat_id = $update->message->chat->id;
        $update->post_fields[1]->text = 'Registration cancelled. You can start again now.';
    } else if ($result["type"] == "sub") {
        $target = explode('_', $result['current_stat']);
        $hotelid= $target[1];
        delete_hotel_info($hotelid);
        //delete room inf
        $rooms = get_hotel_rooms($hotelid);
       while ($room = $rooms->fetch_assoc()) {
        $room_id = $room["id"];
        delete_room_info($room_id);
        }
        del_status($userid);
        $update->method[1] = 'sendMessage';
        $update->post_fields[1] = new \stdClass();
        $update->post_fields[1]->chat_id = $update->message->chat->id;
        $update->post_fields[1]->text = 'Submission cancelled.You can start again now.';
    } else if ($result["type"] == "room") {
        $target = explode('_', $result['current_stat']);
        $room_id= $target[1];
        $hotel_id=get_room_info($room_id)["hotel_id"];
        delete_room_info($room_id);
       $update->method[0] = 'sendMessage';
        $update->post_fields[0]->chat_id = $update->message->chat->id;
        $update->post_fields[0]->text = "Room submission canceled successfully. /cancel to cancel hotel submission too!$hotel_id ";
        $keyboard = [
            [['text' => 'Add bedroom 🛏'],],
            [['text' => 'Complete Submission'],],
        ];
        $update->post_fields[0]->reply_markup = json_encode(array(
        'keyboard' => $keyboard, 'one_time_keyboard' => true
        ));
        set_status($userid, "sub", "submissionDirector_$hotel_id");
    }else {
        del_status($userid);
        $update->method[1] = 'sendMessage';
        $update->post_fields[1] = new \stdClass();
        $update->post_fields[1]->chat_id = $update->message->chat->id;
        $update->post_fields[1]->text = 'No operation currently open.';
    }
}
