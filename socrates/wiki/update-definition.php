<?php 
require_once('../xanthippe/includes/sql-jperetz.php');

if ($_POST['definition']) {
	$updatedef = $mysqli->query('update definition set definition = "'. $_POST['update']  . '"where definition_id = '.$_POST['definition']);
    $updatedef->close();
}
$mysqli->close();