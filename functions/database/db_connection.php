<?php

//create a db connection 
//delta.cloudns.io
class db_connection{


    protected static function connect(){
        $dbhost = "localhost";
        $dbuser = "larkwallcom_MCV_bot";
        $dbpass = "n#Aq2R!7nj.0";
        $dbname = "larkwallcom_MCV_bot";
        
        $conn = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
        
        return $conn;
    }
}
//$dbhost = "localhost";
//$dbuser = "larkwallcom_MCV_bot";
//$dbpass = "n#Aq2R!7nj.0";
//$dbname = "larkwallcom_MCV_bot";
//$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
//mysqli_set_charset($connection, 'utf8');
////test if the connection occured.
////more validations
//if (mysqli_connect_errno()) {
//    die("db connection failed: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
//}
?>