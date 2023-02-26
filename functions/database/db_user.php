<?php

class db_user extends db_connection {

///

    private function generateGUID() {
        $base = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx';
        $id = [];

        foreach (str_split($base) as $char) {
            if ($char !== 'x' && $char !== 'y') {
                $id[] = $char;
                continue;
            }
            $r = rand(0, 15) | 0;
            $hex = $char === 'x' ? $r : ($r & 0x3) | 0x8;
            $id[] = dechex($hex);
        }

        return implode('', $id);
    }

    private function generateToken($num_bytes = 20) {
        return bin2hex(openssl_random_pseudo_bytes($num_bytes));
    }

    private function createBasicAuthHeader(string $client_id, string $auth_token) {
        return [
            'Authorization' => 'Basic ' . base64_encode($client_id . ':' . $auth_token)
        ];
    }

    public static function get_user($user_id) {
        $query = "SELECT * FROM users WHERE `user_id` = $user_id ;";

        $result = parent::connect()->query($query);
        $myresult = $result->fetch_array();
        return $myresult;
    }

    public function new_user($user_id) {
       
        if (db_user::get_user($user_id)) {
            //DO something
            return; //
        } else {
            $UID = $this->generateGUID();
            $token = $this-> generateToken();

            $query = "INSERT INTO ";
            $query .= "users (user_id,UID,token) ";
            $query .= " VALUES ('$user_id','$UID','$token') ;";
            $result = parent::connect()->query($query);
            return $result;
        }
    }


}
