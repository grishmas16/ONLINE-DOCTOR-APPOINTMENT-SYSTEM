<?php 

	if (session_status() === PHP_SESSION_NONE) { session_save_path(__DIR__ . "/sessions"); @session_start(); }

	$_SESSION = array();

	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-86400, '/');
	}

	session_destroy();

	// redirecting the user to the login page
	header('Location: login.php?action=logout');

 ?>

