<?php

include_once('functions.php');

$modUserID = $_POST["id"];
$modUsername = $_POST["userName"];

if ( isset($modUserID) && isset($modUsername) ) {
	
	$success = modify_user($modUserID, $modUsername);
	
	if ( $success ) {
		header('Location: users.php');
	} else {
		echo 'An error occurred during the modify of the user.';
	}
	
} else {
	echo 'An error occurred during the modify of the user.';
	
}

?>
