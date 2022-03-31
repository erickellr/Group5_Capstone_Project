<?php
function checkLogin($firstName, $lastName) {
    $db = new SQLite3('db/info.db');
    $db->exec('BEGIN EXCLUSIVE;');
    $query = "SELECT * FROM userInfo WHERE lastname = '$lastName'";
    $queryResult = $db->querySingle($query, true);
    error_log(print_r($queryResult, true));
    if (count($queryResult) === 0) {
	$query = "INSERT INTO userInfo (firstname, lastname) values ('$firstName', '$lastName')";
	$db->exec($query);
	$loginResult = array('status' => TRUE, 'info' => 'User Created');	
    } else {
	$loginResult = array('status' => FALSE, 'info' => 'Existing User');
    }
    $db->exec('END;');
    $db->close();
    return $loginResult;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = file_get_contents('php://input');
    $postDecoded = json_decode($postData);
    $firstName = $postDecoded->firstName;
    $lastName = $postDecoded->lastName;
    error_log("Server received login ID: " . $firstName . ", password: " . $lastName . "\n");

    $loginResult = checkLogin($firstName, $lastName);

    $jsonToSend = json_encode($loginResult);
    error_log("Server sending response: " . $jsonToSend);
    echo $jsonToSend;
}
?>