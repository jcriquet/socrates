<?php 
require_once('sql-jperetz.php');
if ($_POST['homework_id']) {
  $newrow = $mysqli->prepare("insert into review (student_email, homework_homework_id, comment, grade) values (?,?,?,?)");
  $newrow->bind_param('siss',$_POST['student_email'],$_POST['homework_id'],$_POST['comment'],$_POST['grade']);
  $newrow->execute(); 
   $selectnewreview = $mysqli->query("select max(review_id) as review_id ,  homework_homework_id,  student_email , comment, grade from review group by homework_homework_id,  student_email , comment, grade order by review_id desc limit 1");
   $newreview = $selectnewreview->fetch_object();
   $selectname = $mysqli->query('select first_name from student where email ="'.$newreview->student_email.'"');
   $newname = $selectname->fetch_object();
   $newreview->first_name = $newname->first_name;
   $selectexercise = $mysqli->query('select lesson_lesson_id, exercise_id from homework, exercise where exercise_id = exercise_exercise_id and homework_id = '.$newreview->homework_homework_id);
   $exercise = $selectexercise->fetch_object();
   $newreview->lesson_id = $exercise->lesson_lesson_id;
   $newreview->exercise_id = $exercise->exercise_id;
   $mysqli->close();
  require_once('JSON.php');
    $json = new Services_JSON;
   $insertedreview = $json->encode($newreview);
   echo $insertedreview;
} 