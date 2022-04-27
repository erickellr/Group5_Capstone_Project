<?php
function checkLogin($query) {
    $db = new SQLite3('db/individual.db');
    $db->exec('BEGIN EXCLUSIVE;');
	$verifyUser = "SELECT username FROM userInfo WHERE username == '$query'";
	$verifyResult = $db->querySingle($verifyUser, false);
	if ($verifyResult == null){
		$loginResult = array('info' => null);
		return $loginResult;
	} else {
		$queryResult = $db->query("SELECT memberStatus FROM userInfo WHERE username == '$query'");
		$memberResult = $queryResult->fetchArray();
		error_log(print_r($memberResult[0], true));
		$loginResult = $memberResult[0];
	}

    $db->exec('END;');
    $db->close();
    return $loginResult;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = file_get_contents('php://input');
    $postDecoded = json_decode($postData);
    $query = $postDecoded->query;
    error_log("Server received username: " . $query . "\n");

    $loginResult = checkLogin($query);

    $jsonToSend = json_encode($loginResult);
    error_log("Server sending response: " . $jsonToSend);
    echo $jsonToSend;
}
?>