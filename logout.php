<?php
	session_start();

	session_unset();						// Clearing session variables.
	session_destroy();						// Deleting session.

	header("Location: index.php");			// Redirect...
?>