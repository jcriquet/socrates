<?php

// load an external JSON library - required for php v5.1
require_once("../xanthippe/includes/JSON.php");
//  create a json service
$json = new Services_JSON;
// load an external rest services library
require_once("../xanthippe/includes/rest.php");
/* Create a MySQL Connection */
require_once("../xanthippe/includes/sql-jperetz.php");
// get the request data object
$data = RestUtils::processRequest();
//get the request variable for the syllabus id
$requestVars = $data->getRequestVars();
$syllabus_request =  $requestVars["syllabus_id"];
// process request based on the method
switch($data->getMethod())
{
	case 'put':
	if ($syllabus_request) {
	
	}
		break;
	case 'post':
	/* no support for GET method yet */
		break;
	case 'get':
	/* check for the syllabus_id POST request variable */
	if ($syllabus_request) {
		/* Select the requested syllabus */
if ($syllabi = $mysqli->query("SELECT syllabus_id, semester, section_number, course_name, srjc_id, repository FROM course, syllabus where syllabus.course_course_id = course.course_id and syllabus_id=".$syllabus_request)) 
 { 
  while ($syllabus = $syllabi->fetch_object())
  {
   $syllabus_array[$syllabus->syllabus_id] = $syllabus;
   
   /* Select the lessons in date order */
	if ($lessons = $mysqli->query("SELECT lesson_id, topics, description, lesson.lesson_date as sort_date, DATE_FORMAT(lesson_date,'%M %e, %Y' ) as lesson_date ,blogpost FROM lesson  WHERE syllabus_syllabus_id = ".$syllabus->syllabus_id." ORDER BY sort_date ASC")) {
   while ($lesson = $lessons->fetch_object())
    {
	  $syllabus_array[$syllabus->syllabus_id]->lessons[$lesson->lesson_id] = $lesson;
	  /* Select the reading */
	  if ($reads = $mysqli->query("SELECT read_id,description, title, ISDN, author, url, cover_image, optional, reading_url FROM reading LEFT JOIN resource on (resource.resource_id = reading.resource_resource_id) where lesson_lesson_id =".$lesson->lesson_id)) {
   while ($read = $reads->fetch_object())
    {
		$syllabus_array[$syllabus->syllabus_id]->lessons[$lesson->lesson_id]->reads[$read->read_id] = $read;
	}
	  }
	  if ($explores = $mysqli->query("SELECT explore_id, description, resource_type, url FROM explore where lesson_lesson_id =".$lesson->lesson_id)) {
   while ($explore = $explores->fetch_object())
    {
		$syllabus_array[$syllabus->syllabus_id]->lessons[$lesson->lesson_id]->explores[$explore->explore_id] = $explore;
	}
	  }
	  if ($exercises = $mysqli->query("SELECT exercise_id,description, url FROM exercise where lesson_lesson_id =".$lesson->lesson_id)) {
   while ($exercise = $exercises->fetch_object())
    {
		$syllabus_array[$syllabus->syllabus_id]->lessons[$lesson->lesson_id]->exercises[$exercise->exercise_id] = $exercise;
		
	}
	  }
	 }
   }
   }
    /* free result set */
    $syllabi->close();
}
/* close SQL connectiot */
$mysqli->close();

//echo $json->encode($syllabus_array);
$resultData = $json->encode($syllabus_array);

RestUtils::sendResponse(200, $resultData, 'application/json');
		break;
}
}

?>
