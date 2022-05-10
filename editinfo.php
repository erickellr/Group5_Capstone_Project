<?php
function checkLogin($firstName, $lastName, $email, $street, $city, $state, $zip, $username) {
    $db = new SQLite3('db/individual.db');
    $db->exec('BEGIN EXCLUSIVE;');
    $query = "SELECT username FROM userInfo WHERE username == '$username'";
    $queryResult = $db->querySingle($query, true);
    error_log(print_r($queryResult, true));
    if (count($queryResult) === 1) {
	$updateFN = "UPDATE userInfo SET firstname='$firstName' WHERE username == '$username'";
	$updateLN = "UPDATE userInfo SET lastname='$lastName' WHERE username == '$username'";
	$updateEmail = "UPDATE userInfo SET email='$email' WHERE username == '$username'";
	$updateStreet = "UPDATE userInfo SET street='$street' WHERE username == '$username'";
	$updateCity = "UPDATE userInfo SET city='$city' WHERE username == '$username'";
	$updateState = "UPDATE userInfo SET state='state' WHERE username == '$username'";
	$updateZip = "UPDATE userInfo SET zip='zip' WHERE username == '$username'";
	$db->exec($updateFN);
	$db->exec($updateLN);
	$db->exec($updateEmail);
	$db->exec($updateState);
	$db->exec($updateStreet);
	$db->exec($updateZip);
	$db->exec($updateCity);
	$address = $street . ' ' . $city . " " . $state . " " . $zip;
	$loginResult = array('username' => $username, 'firstname' => $firstName, 'lastname' => $lastName, 'email' => $email, 'address' => $address);
	}else{
	$loginResult = "Invalid Username";
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
    $username = $postDecoded->username;
    error_log("Server received login ID: " . $firstName . ", password: " . $lastName . "\n");

    $loginResult = checkLogin($firstName, $lastName, $email, $street, $city, $state, $zip, $username);

    $jsonToSend = json_encode($loginResult);
    error_log("Server sending response: " . $jsonToSend);
    echo $jsonToSend;
}
?>