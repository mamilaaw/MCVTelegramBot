<?php
function send_response($update) {
  // Keep track of which iteration of the loop you're in for $update->post_fields
  $i = 0;
  $response = array();
  // Now go through the array and send each $method and $post_fields
  foreach ($update->method as $method) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.telegram.org/bot" . BOT_TOKEN . "/$method", 
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => http_build_query($update->post_fields[$i]),
      CURLOPT_HTTPHEADER => array(
        "Content-Type: application/x-www-form-urlencoded"
      ),
    ));
    $response[$i] = curl_exec($curl);
    curl_close($curl);
    $i++;
    
  }
$update->method = array();
$update->post_fields = array();
// There will always be at least one response
$update->post_fields[0] = new \stdClass();
  return json_encode($response);
}
