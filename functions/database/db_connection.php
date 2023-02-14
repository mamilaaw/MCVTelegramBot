<?php
	//create a db connection 
//delta.cloudns.io
	$dbhost="localhost";
	$dbuser="larkwallcom_marefia_bot_user";
	$dbpass="!superegg!+";
	$dbname="larkwallcom_marefia_bot";
	$connection=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
        mysqli_set_charset($connection , 'utf8');
	//test if the connection occured.
        //more validations
		if (mysqli_connect_errno()){ die ("db connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");} 
?>