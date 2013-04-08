<?php 
require_once('sql-jperetz.php');
$newcontent = $_GET['exercise_id'];
if ($newcontent['exercise_id']) {
  $readupdate = $mysqli->prepare("update exercise set description = ? , url = ? where exercise_id = ?");
  $readupdate->bind_param('ssi',$newcontent['description'],$newcontent['url'],$newcontent['exercise_id']);
  $readupdate->execute();
  $mysqli->close();
} else {
	$readinsert = $mysqli->prepare("insert into exercise (lesson_lesson_id, description,url) values (?,?,?)");
	$readinsert->bind_param('iss',$_GET['lesson_id'], $_GET['description'],$_GET['url']);
	$readinsert->execute();
	$selectnewread = $mysqli->query("select max(exercise_id) as exercise_id , description, url from exercise group by description,url order by exercise_id desc limit 1;");
	$newread = $selectnewread->fetch_object();
	$mysqli->close();
	require_once('JSON.php');
    $json = new Services_JSON;
	$insertedRead = $json->encode($newread);
	echo $insertedRead;
}