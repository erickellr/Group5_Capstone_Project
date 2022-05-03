<?php
function checkLogin($firstName, $lastName, $email, $street, $city, $state, $zip, $model, $username, $password) {
    $db = new SQLite3('db/individual.db');
    $db->exec('BEGIN EXCLUSIVE;');
    $query = "SELECT * FROM userInfo WHERE username = '$username'";
    $queryResult = $db->querySingle($query, true);
    error_log(print_r($queryResult, true));
    if (count($queryResult) === 0) {
	$query = "INSERT INTO userInfo (firstname, lastname, email, street, city, state, zip, model, username, password, memberStatus) values ('$firstName', '$lastName', '$email', '$street', '$city', '$state', '$zip', '$model', '$username', '$password', 0)";
	$db->exec($query);
	$loginResult = array('username' => $username);	
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
    $email = $postDecoded->email;
    $street = $postDecoded->street;
	$city = $postDecoded->city;
	$state = $postDecoded->state;
	$zip = $postDecoded->zip;
    $model = $postDecoded->model;
    $username = $postDecoded->username;
    $password = $postDecoded->password;
    error_log("Server received login ID: " . $firstName . ", password: " . $lastName . "\n");

    $loginResult = checkLogin($firstName, $lastName, $email, $street, $city, $state, $zip, $model, $username, $password);

    $jsonToSend = json_encode($loginResult);
    error_log("Server sending response: " . $jsonToSend);
    echo $jsonToSend;
}
?>