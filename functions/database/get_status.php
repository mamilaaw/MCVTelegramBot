<?php
function get_status($user_id){
    global $connection;
    $query = "SELECT * FROM status WHERE `userid` = $user_id ;";
    
    $result = mysqli_query($connection, $query);
    $myresult= mysqli_fetch_array($result);//
    return $myresult;
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

