<?php
function checkLogin($query) {
    $db = new SQLite3('db/individual.db');
    $db->exec('BEGIN EXCLUSIVE;');
    $querydb = "SELECT username FROM userInfo WHERE username == '$query'";
    $queryResult = $db->querySingle($querydb, false);
    error_log(print_r($queryResult, true));
    if ($queryResult === $query){
    	$loginResult = $queryResult;
    } else {
	$loginResult = array('status' => False, 'info' => 'invalid last name');
	return $loginResult;
    }
    $db->exec('END;');
    $db->close();
    return $loginResult;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = file_get_contents('php://input');
    $postDecoded = json_decode($postData);
    $query = $postDecoded->query;
    error_log("Server received last name: " . $query . "\n");

    $loginResult = checkLogin($query);

    $jsonToSend = json_encode($loginResult);
    error_log("Server sending response: " . $jsonToSend);
    echo $jsonToSend;
}
?>