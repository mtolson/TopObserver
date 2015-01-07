<?php
	session_start();
	unset($_SESSION['user_fname']);
	unset($_SESSION['user_id']);
	header("Location: index.php");
	?>

