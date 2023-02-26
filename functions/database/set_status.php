<?php

function set_status($userid, $type,$current_stat){
    global $connection;
    if (get_status($userid)){
    $query = "UPDATE";
    $query .= " status set type = \"$type\" , current_stat = \"$current_stat\" WHERE userid = $userid; ";
    $result = mysqli_query($connection, $query);
    return $result;
    }else{
    $query = "INSERT INTO ";
    $query .= "status (userid,type,current_stat) ";
    $query .= " VALUES ('$userid','$type','$current_stat') ;";
    $result = mysqli_query($connection, $query);
    return $result;
    }
}
function del_status($userid){
    global $connection;
    $query = "DELETE from";
    $query .= " status  WHERE userid = $userid; ";
    $result = mysqli_query($connection, $query);
    return $result;
         
}