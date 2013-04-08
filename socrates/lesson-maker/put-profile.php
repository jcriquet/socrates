<?php 
require_once('sql-jperetz.php');
$newcontent = $_POST['profile'];
if ($newcontent['email']) {
  $profileupdate = $mysqli->prepare("update student set gallery_URL = ? , github_userid = ? where email = ?");
  $profileupdate->bind_param('sss',$newcontent['gallery_URL'],$newcontent['github_userid'],$newcontent['email']);
  $profileupdate->execute();
  $projectupdate = $mysqli->prepare("update class set project_description = ? where student_email = ? and syllabus_syllabus_id = ?");
  $projectupdate->bind_param('sss',$newcontent['project_description'],$newcontent['email'],$newcontent['syllabus_id']);
  $projectupdate->execute();
  $profileupdate->close();
  $projectupdate->close();
} 
$mysqli->close();