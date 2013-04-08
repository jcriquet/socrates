<?php
session_start();

if (isset($_SESSION['user'])) {
	print "Logged in as {$_SESSION['user']}";
} else {
	header('Location: ./login.php');
}
?>