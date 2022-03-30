<?php
function checkLogin($loginID, $password) {
    $db = new SQLite3('db/elliptigo.db');
    $db->exec('BEGIN EXCLUSIVE;');
    $query = "SELECT * FROM players WHERE loginID = '$loginID'";
    $queryResult = $db->querySingle($query, true);
    error_log(print_r($queryResult, true));
    if (count($queryResult) === 0) {
	$passwordHash = password_hash($password, PASSWORD_DEFAULT);
	$query = "INSERT INTO players (loginID, passwordHash, gamesPlayed, gamesWon) values ('$loginID', '$passwordHash', 0, 0)";
	$db->exec($query);
	$loginResult = array('status' => TRUE, 'info' => 'new login ID');	
    } else {
	if (password_verify($password, $queryResult["passwordHash"])) {
	    $loginResult = array('status' => TRUE, 'info' => 'Authenticated existing ID');
	} else {
	    $loginResult = array('status' => FALSE, 'info' => 'Incorrect password for exsiting ID');
	}
    }
    $db->exec('END;');
    $db->close();
    return $loginResult;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = file_get_contents('php://input');
    $postDecoded = json_decode($postData);
    $loginID = $postDecoded->loginID;
    $password = $postDecoded->password;
    error_log("Server received login ID: " . $loginID . ", password: " . $password . "\n");

    $loginResult = checkLogin($loginID, $password);

    $jsonToSend = json_encode($loginResult);
    error_log("Server sending response: " . $jsonToSend);
    echo $jsonToSend;
}
?>