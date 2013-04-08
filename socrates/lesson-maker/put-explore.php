<?php 
require_once('sql-jperetz.php');
$newcontent = $_GET['explore_id'];
if ($newcontent['explore_id']) {
  $readupdate = $mysqli->prepare("update explore set description = ? , url = ? where explore_id = ?");
  $readupdate->bind_param('ssi',$newcontent['description'],$newcontent['url'],$newcontent['explore_id']);
  $readupdate->execute();
  $mysqli->close();
} else {
	$readinsert = $mysqli->prepare("insert into explore (lesson_lesson_id, description,url) values (?,?,?)");
	$readinsert->bind_param('iss',$_GET['lesson_id'], $_GET['description'],$_GET['url']);
	$readinsert->execute();
	$selectnewread = $mysqli->query("select max(explore_id) as explore_id , description, url from explore group by description,url order by explore_id desc limit 1;");
	$newread = $selectnewread->fetch_object();
	$mysqli->close();
	require_once('JSON.php');
    $json = new Services_JSON;
	$insertedRead = $json->encode($newread);
	echo $insertedRead;
}