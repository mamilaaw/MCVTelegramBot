<?php

class db_status extends db_connection {
    
    public static function get_status($user_id) {
        $query = "SELECT * FROM status WHERE `user_id` = $user_id ;";

        $result = parent::connect()->query($query);
        $myresult = $result->fetch_assoc();
        return $myresult;
    }

    public static function set_status($user_id, $type, $current_stat) {
        if (db_status::get_status($user_id)) {
            $query = "UPDATE";
            $query .= " status set type = \"$type\" , current_stat = \"$current_stat\" WHERE user_id = $user_id; ";
            $result = parent::connect()->query($query);
            return $result;//
        } else {
            $query = "INSERT INTO ";
            $query .= "status (user_id,type,current_stat) ";
            $query .= " VALUES ('$user_id','$type','$current_stat') ;";
            $result = parent::connect()->query($query);
            return $result;
        }
    }

    public static function del_status($user_id) {
        $query = "DELETE from";
        $query .= " status  WHERE user_id = $user_id; ";
        $result = parent::connect()->query($query);
            return $result;
    }

}
