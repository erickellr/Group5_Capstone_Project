<?php
function checkLogin($PW) {
    $db = new SQLite3('db/individual.db');
    $db->exec('BEGIN EXCLUSIVE;');
	$verifyUser = "SELECT password FROM userInfo WHERE password == '$PW'";
	$verifyResult = $db->querySingle($verifyUser, false);
	if ($verifyResult == $PW){
		$profileQuery = "SELECT username, password FROM userInfo WHERE password == '$PW'";
		$profileResult = $db->querySingle($profileQuery, false);
		$loginResult = $profileResult->fetchArray();
		error_log($loginResult);
		return $loginResult;
	}

    $db->exec('END;');
    $db->close();
    error_log($loginResult);
    return $loginResult;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = file_get_contents('php://input');
    $postDecoded = json_decode($postData);
    $PW = $postDecoded->PW;

    //$loginResult = checkLogin($PW);
    $loginResult = "jim";

    $jsonToSend = json_encode($loginResult);
    error_log("Server sending response: " . $jsonToSend);
    echo $jsonToSend;
}
?>