<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['type'] !== 'instructor') {
	header('Location: ../xanthippe/login.php?redirect='.$_SERVER['REQUEST_URI']);
}
?>