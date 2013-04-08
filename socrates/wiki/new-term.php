<?php 
require_once('../xanthippe/includes/sql-jperetz.php');
if ($_POST['term']) {
	$newterm = $mysqli->query('select term from term where term ="'.$_POST['term'].'"');
	if ($newterm != "") {
		$insertterm = $mysqli->prepare('insert into term (term) values (?)');
		$insertterm->bind_param('s',$_POST['term']);
		$insertterm->execute();
	
	}
	$insertdef = $mysqli->prepare('insert into definition (term_term, definition, student_email) values (?,?,?)');
	$insertdef->bind_param('sss',$_POST['term'],$_POST['definition'],$_POST['student_email']);
	$insertdef->execute();
	
}
$mysqli->close();