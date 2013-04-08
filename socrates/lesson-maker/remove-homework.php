<?php 
require_once('../xanthippe/includes/sql-jperetz.php');
echo $_POST['homework'];
if ($_POST['homework']) {
	$deleteterm = $mysqli->query('delete from homework where homework_id = '.$_POST['homework']);
	$deleteterm->execute(); 
    $deleteterm->close();
}
$mysqli->close();