<?php
	unset($_COOKIE['uid']);
	setcookie('uid', '', time() - 3600);
	echo "<script>";
	echo "window.location.href = 'login.html';";
	echo "</script>";
?>