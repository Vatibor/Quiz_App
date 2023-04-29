<?php

include_once('functions.php');

$deleteUSer = $_POST["id"];

if ( isset($deleteUSer) ) {
	
	$success = delete_user($deleteUSer);
	
	if ( $success ) {
		header('Location: users.php');
	} else {
		echo 'An error occurred during the deletion of the user.';
	}
	
} else {
	echo 'An error occurred during the deletion of the user.';
	
}

?>
