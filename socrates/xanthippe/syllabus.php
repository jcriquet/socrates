<?php

// load an external JSON library - required for php v5.1
require_once("includes/JSON.php");
//create a json service
$json = new Services_JSON;
//load an external rest services library
require_once("includes/rest.php");
/* Create a MySQL Connection */
require_once("includes/sql-jperetz.php");
//get the request data object
$data = RestUtils::processRequest();
//get the request variable for the syllabus id
$requestVars = $data->getRequestVars();
$syllabus_request =  $requestVars["syllabus_id"];
//process request based on the method
switch($data->getMethod()) {
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
		if ($syllabi = $mysqli->query("SELECT syllabus_id, semester, section_number, course_name, srjc_id, repository FROM course, syllabus where syllabus.course_course_id = course.course_id and syllabus_id=".$syllabus_request)) {
			while ($syllabus = $syllabi->fetch_object()) {
				$syllabus_array[$syllabus->syllabus_id] = $syllabus;
				/* Select the students in the class */
				$studentquery = "SELECT email, first_name, last_name, gallery_URL, github_userid , type , project_description FROM student , class where email = student_email and syllabus_syllabus_id = ".$syllabus->syllabus_id." ORDER BY first_name";
				if ($students = $mysqli->query($studentquery)) {
					while ($student = $students->fetch_object()) {
						$student->gravatar_hash = md5( strtolower( trim($student->email ) ) );
						$syllabus_array[$syllabus->syllabus_id]->students[$student->email] = $student;
						// get homework for each student
						if ($hwsubmissions = $mysqli->query('SELECT topics, homework_id,student_email, first_name, comment, homework.URL url FROM homework , student , exercise, lesson where student_email = email and exercise_exercise_id = exercise_id and lesson_lesson_id = lesson_id and email="'.$student->email.'"')) {
							while ($hwsubmission = $hwsubmissions->fetch_object()) {
								$syllabus_array[$syllabus->syllabus_id]->students[$student->email]->homeworks[$hwsubmission->homework_id] =  $hwsubmission;
							}
						}
					}
				}
				/* Select the lessons in date order */
				if ($lessons = $mysqli->query("SELECT lesson_id, topics, description, lesson.lesson_date as sort_date, DATE_FORMAT(lesson_date,'%M %e, %Y' ) as lesson_date ,blogpost FROM lesson  WHERE syllabus_syllabus_id = ".$syllabus->syllabus_id." ORDER BY sort_date ASC")) {
					while ($lesson = $lessons->fetch_object()) {
						$syllabus_array[$syllabus->syllabus_id]->lessons[$lesson->lesson_id] = $lesson;
					}
				}
				
				/* Select the assignments in position order */
/*
				if ($lessons = $mysqli->query("SELECT lesson_id, topics, description, lesson.lesson_date as sort_date, DATE_FORMAT(lesson_date,'%M %e, %Y' ) as lesson_date ,blogpost FROM lesson  WHERE syllabus_syllabus_id = ".$syllabus->syllabus_id." ORDER BY sort_date ASC")) {
					while ($lesson = $lessons->fetch_object()) {
						$syllabus_array[$syllabus->syllabus_id]->lessons[$lesson->lesson_id] = $lesson;
					}
				}
*/
			}
			/* free result set */
			$syllabi->close();
			
			/* Select the current student's grades */
/*
			if ($grades = $mysqli->query("SELECT syllabus_id, semester, section_number, course_name, srjc_id, repository FROM course, syllabus where syllabus.course_course_id = course.course_id and syllabus_id=".$syllabus_request)) {
				while ($syllabus = $syllabi->fetch_object()) {
					$syllabus_array[$syllabus->syllabus_id] = $syllabus;
					/* Select the students in the class */
/*
					if ($students = $mysqli->query("SELECT email, first_name, last_name, gallery_URL, github_userid , type , project_description FROM student , class where email = student_email and syllabus_syllabus_id =".$syllabus->syllabus_id)) {
						while ($student = $students->fetch_object()) {
							$student->gravatar_hash = md5( strtolower( trim($student->email ) ) );
							$syllabus_array[$syllabus->syllabus_id]->students[$student->email] = $student;
							// get homework for each student
							if ($hwsubmissions = $mysqli->query('SELECT topics, homework_id,student_email, first_name, comment, homework.URL url FROM homework , student , exercise, lesson where student_email = email and exercise_exercise_id = exercise_id and lesson_lesson_id = lesson_id and email="'.$student->email.'"')) {
								while ($hwsubmission = $hwsubmissions->fetch_object()) {
									$syllabus_array[$syllabus->syllabus_id]->students[$student->email]->homeworks[$hwsubmission->homework_id] =  $hwsubmission;
								}
							}
						}
					}
					/* Select the lessons in date order */
/*
					if ($lessons = $mysqli->query("SELECT lesson_id, topics, description, lesson.lesson_date as sort_date, DATE_FORMAT(lesson_date,'%M %e, %Y' ) as lesson_date ,blogpost FROM lesson  WHERE syllabus_syllabus_id = ".$syllabus->syllabus_id." ORDER BY sort_date ASC")) {
						while ($lesson = $lessons->fetch_object()) {
							$syllabus_array[$syllabus->syllabus_id]->lessons[$lesson->lesson_id] = $lesson;
						}
					}
				}
				/* free result set */
/*
				$syllabi->close();
*/
			//$_SESSION['user']['email']
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
