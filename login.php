<?php
function checkLogin($username, $password) {
    $db = new SQLite3('db/individual.db');
    $db->exec('BEGIN EXCLUSIVE;');
    $querydbUser = "SELECT username FROM userInfo WHERE username = '$username'";
    $querydbPass = "SELECT password FROM userInfo WHERE password = '$password'";
    $queryUserResult = $db->querySingle($querydbUser, false);
    $queryPassResult = $db->querySingle($querydbPass, false);
    error_log(print_r($queryResult, true));
    if ($queryUserResult === $username){
    	$loginResult = array('status' => TRUE, 'info' => 'last name match');
    } else {
	$loginResult = array('status' => FALSE, 'info' => 'invalid last name');
    }
    $db->exec('END;');
    $db->close();
    return $loginResult;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = file_get_contents('php://input');
    $postDecoded = json_decode($postData);
    $username= $postDecoded->username;
    $password= $postDecoded->password;
    error_log("Server received last name: " . $query . "\n");

    $loginResult = checkLogin($username, $password);

    $jsonToSend = json_encode($loginResult);
    error_log("Server sending response: " . $jsonToSend);
    echo $jsonToSend;
}
?>