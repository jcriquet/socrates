<?php 
require_once('sql-jperetz.php');
$selectbooks = $mysqli->query("select resource_id, title from resource");
while ($book = $selectbooks->fetch_object())
{
	$books[$book->resource_id] = $book;
}
$mysqli->close();	
	require_once('JSON.php');
    $json = new Services_JSON;
	$booksList = $json->encode($books);
	echo $booksList;