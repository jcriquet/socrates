<?php 
require_once('sql-jperetz.php');
$newcontent = $_GET['reading_id'];
if ($newcontent['read_id']) {
  $readupdate = $mysqli->prepare("update reading set description = ? , reading_url = ? where read_id = ?");
  $readupdate->bind_param('ssi',$newcontent['description'],$newcontent['reading_url'],$newcontent['read_id']);
  $readupdate->execute();
  $mysqli->close();
} else {
	if ($_GET['resource_id'] == "") {
		$_GET['resource_id'] = NULL;
	}
	$readinsert = $mysqli->prepare("insert into reading (lesson_lesson_id, resource_resource_id, description,reading_url) values (?,?,?,?)");
	$readinsert->bind_param('iiss',$_GET['lesson_id'], $_GET['resource_id'], $_GET['description'],$_GET['reading_url']);
	$readinsert->execute();
//	$readinsert->close();
	$selectnewread = $mysqli->query("select max(read_id) as read_id , resource_resource_id, description, reading_url from reading  group by description, reading_url order by read_id desc limit 1");
	$newread = $selectnewread->fetch_object();
//	$selectnewread->close();
	if ($newread->resource_resource_id) {
	$selectresource = $mysqli->query("select title from resource where resource_id =".$newread->resource_resource_id);
	$newresource = $selectresource->fetch_object();
	$mysqli->close();
	$newread->title = $newresource->title;
	}
	require_once('JSON.php');
    $json = new Services_JSON;
	$insertedRead = $json->encode($newread);
	echo $insertedRead;
}