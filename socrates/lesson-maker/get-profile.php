<?php 
require_once('sql-jperetz.php');
$selectprofile = $mysqli->query('select * from student, class where class.student_email = student.email and class.student_email ="'.$_GET['email'].'" and syllabus_syllabus_id = "'.$_GET['syllabus_id'].'"');
$profile = $selectprofile->fetch_object();
$profile->gravatar_hash = md5( strtolower( trim($profile->email) ) );
$mysqli->close();
require_once('JSON.php');
$json = new Services_JSON;
$profile = $json->encode($profile);
echo $profile;