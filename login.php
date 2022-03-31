<?php
function checkLogin($query) {
    $db = new SQLite3('db/elliptigo.db');
    $db->exec('BEGIN EXCLUSIVE;');
    $querydb = "SELECT * FROM players WHERE loginID = '$query'";
    $queryResult = $db->querySingle($querydb, true);
    error_log(print_r($queryResult, true));
    if ($queryResult === $query){
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
    $query = $postDecoded->query;
    error_log("Server received last name: " . $query . "\n");

    $loginResult = checkLogin($query);

    $jsonToSend = json_encode($loginResult);
    error_log("Server sending response: " . $jsonToSend);
    echo $jsonToSend;
}
?>