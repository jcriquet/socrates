<?php 
require_once('../xanthippe/includes/sql-jperetz.php');
echo $_POST['review'];
if ($_POST['review']) {
	$deletehw = $mysqli->query('delete from review where review_id = '.$_POST['review']);
	$deletehw->execute(); 
    $deletehw->close();
}
$mysqli->close();