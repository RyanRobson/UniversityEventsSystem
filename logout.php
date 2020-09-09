<?php
	session_start();
	unset($_SESSION['emailAddress']);
	unset($_SESSION['staff']);
	unset($_SESSION['user_id']);
	header("Location: index.php");
	echo"Logged out";
?>