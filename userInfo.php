<?php
  $postData = file_get_contents('php://input');
  $postDecoded = json_decode($postData);
  $loginID = $postDecoded->loginID;
  $password = $postDecoded->password;
  error_log("Server received login ID: " . $loginID . ", password: " . $password . "\n");
  $loginResult = json_encode($loginID);
  echo $loginResult
}
?>