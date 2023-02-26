<?php

$errors=array();

function has_presence($value)
 {
	return (isset($value) && $value!=="");
 } 
function has_max_length($value,$max){
	return strlen($value)<= $max;
	}
function has_max_value($value,$max){
	return $value <= $max;
	}
function has_min_value($value,$min){
	return $value >= $min;
	}
function has_min_length($value,$min){
	return strlen($value)>= $min;
	}
function mysqli_prep($string) {
    global $connection;
    $esc = mysqli_real_escape_string($connection, $string);
    return $esc;
}
	
function has_inclusion_in($value,$set)
 {return (in_array($value, $set));
 }
function found_in($value){
 return (strpos($value,"%")===false);
 }
 function confirm_password($one,$two){
     global $errors;
     if($one!==$two){
         $errors["password_err"]="Please reinsert password and confirm properly";
     }
 }

 
?>
<?php

?>
