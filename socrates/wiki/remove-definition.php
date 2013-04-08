<?php 
require_once('../xanthippe/includes/sql-jperetz.php');
echo $_POST['definition'];
if ($_POST['definition']) {
	$deleteterm = $mysqli->query('delete from definition where definition_id = '.$_POST['definition']);
	$deleteterm->execute(); 
    $deleteterm->close();
}
$mysqli->close();