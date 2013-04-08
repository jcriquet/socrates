<?php 
require_once('sql-jperetz.php');
$selectsyllabi = $mysqli->query("select syllabus_id, srjc_id from syllabus, course where course_course_id = course_id and semester = 'Spring 2013'");
while ($syllabi = $selectsyllabi->fetch_object())
{
	$syllabus_array[$syllabi->syllabus_id] = $syllabi;
}
	$mysqli->close();
	require_once('JSON.php');
    $json = new Services_JSON;
	$syllabusList = $json->encode($syllabus_array);
	echo $syllabusList;