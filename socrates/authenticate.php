<?php
session_start();

if (!isset($_SESSION['user'])) {
	require_once('script_root.php');
	header('Location: '.$root_path.'xanthippe/login.php?redirect='.$_SERVER['REQUEST_URI']);
}
?>