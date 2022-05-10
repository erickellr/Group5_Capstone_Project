<?php
function checkLogin($PW) {
    $db = new SQLite3('db/individual.db');
    $db->exec('BEGIN EXCLUSIVE;');
	$verifyUser = "SELECT password FROM userInfo WHERE password == '$PW'";
	$verifyResult = $db->querySingle($verifyUser, false);
	if ($verifyResult == $PW){
		$usernameQuery = "SELECT username FROM userInfo WHERE password == '$PW'";
		$firstnameQuery = "SELECT firstname FROM userInfo WHERE password == '$PW'";
		$lastnameQuery = "SELECT lastname FROM userInfo WHERE password == '$PW'";
		    $street = "SELECT street FROM userInfo WHERE password == '$PW'";
		    $city = "SELECT city FROM userInfo WHERE password == '$PW'";
		    $state = "SELECT state FROM userInfo WHERE password == '$PW'";
		    $zip = "SELECT zip FROM userInfo WHERE password == '$PW'";
		$emailQuery = "SELECT email FROM userInfo WHERE password == '$PW'";
		$modelQuery = "SELECT model FROM userInfo WHERE password == '$PW'";
		$usernameResult = $db->querySingle($usernameQuery, false);
		$firstnameResult = $db->querySingle($firstnameQuery, false);
		$lastnameResult = $db->querySingle($lastnameQuery, false);
		$streetResult = $db->querySingle($street, false);
		$cityResult = $db->querySingle($city, false);
		$stateResult = $db->querySingle($state, false);
		$zipResult = $db->querySingle($zip, false);
		$emailResult = $db->querySingle($emailQuery, false);
		$modelResult = $db->querySingle($modelQuery, false);
		$address = $streetResult . ' ' . $cityResult . ", " . $stateResult . " " . $zipResult;
		$finalArray = [
		    "Username" => $usernameResult,
		    "First Name" => $firstnameResult,
		    "Last Name" => $lastnameResult,
		    "Address" => $address,
		    "Email" => $emailResult,
		    "Elliptigo Model" => $modelResult
		];
		$loginResult = $finalArray;
		return $loginResult;
	}else{
	    $message = "invalid";
	    $loginResult = $message;
	}

    $db->exec('END;');
    $db->close();
    error_log($loginResult);
    return $loginResult;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = file_get_contents('php://input');
    $postDecoded = json_decode($postData);
    $passWord = $postDecoded->PW;
    $loginResult = checkLogin($passWord);

    $jsonToSend = json_encode($loginResult);
    error_log("Server sending response: " . $jsonToSend);
    echo $jsonToSend;
}
?>