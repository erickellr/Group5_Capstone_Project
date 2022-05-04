<?php
function membershipPaid($username){
	$db = new SQLite3('db/individual.db');
    $db->exec('BEGIN EXCLUSIVE;');
    $query = "SELECT * FROM userInfo WHERE username = '$username'";
    $queryResult = $db->querySingle($query, true);
    error_log(print_r($queryResult, true));
	$query = "UPDATE userInfo SET memberStatus = 1 WHERE username = '$username'";
	$db->exec($query);
	$loginResult = array('username' => $username);
	$db->exec('END;');
    $db->close();
	return "Complete";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = file_get_contents('php://input');
    $postDecoded = json_decode($postData);
    $username = $postDecoded->username;
    error_log("Server received login ID: " . $username);

    $payMembership = membershipPaid($username);

    $jsonToSend = json_encode($payMembership);
    error_log("Server sending response: " . $jsonToSend);
    echo $jsonToSend;
}
?>
