<?php 
require_once('authenticate.php');
require_once('script_root.php');
/* Create a MySQL Connection */
require("xanthippe/includes/sql-jperetz.php");
/* Select the requested syllabus */
$stmt = $mysqli->prepare( "SELECT syllabus_id FROM syllabus WHERE uri=?" );
$uri = explode( "/", substr( $_SERVER["REQUEST_URI"], strlen( $_SERVER['SCRIPT_NAME'] ) + 1 ) );
$stmt->bind_param( "s", $uri[ 0 ] );
$stmt->execute();
$stmt->bind_result( $syllabus_id );
$stmt->fetch();
$stmt->close();
$result = $mysqli->query( "SELECT COUNT(lesson_date) FROM lesson WHERE lesson_date <= CURDATE()" );
$currentWeek = $result->fetch_row();
$currentWeek = max( 1, $currentWeek[ 0 ] );
$result->close();
$currentLesson = $uri[ 1 ] ? $uri[ 1 ] : $currentWeek;
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title></title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script src="<?php echo $root_path; ?>bootstrap/js/bootstrap.min.js"></script>
<script src="https://login.persona.org/include.js"></script>
<link href="<?php echo $root_path; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo $root_path; ?>css/spring2013.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
var scriptPath = '<?php echo $_SERVER["SCRIPT_NAME"] ?>';
var syllabusURI = '<?php echo $uri[ 0 ] ?>';
var user = '<?php print $_SESSION['user']['email'] ?>';
var syllabus_id = <?php print $syllabus_id; ?>;
var currentWeek = <?php print $currentWeek; ?>;
var currentLesson = <?php print $currentLesson; ?>;
</script>
<script src="<?php echo $root_path; ?>js/jquery.mobile.custom.min.js"></script>
<script src="<?php echo $root_path; ?>js/spring2013.js"></script>
</head>

<body>
<header class="jumbotron subhead" id="overview">
  <div class="container">
   <h2 class="page-header" id="course-info"></h2>
  </div>
</header>

<div class="container">
 <div id="update-homework" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  
    <h3>Delete Your Exercise Submission</h3>
     
  </div>
  <div class="modal-body"> 
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Close</a>
     <a class="btn btn-danger" id="delete-hw">Delete</a>
  
  </div>
</div>

<div id="update-review" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  
    <h3>Delete Your Comment</h3>
     
  </div>
  <div class="modal-body"> 
  
 </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Close</a>
     <a class="btn btn-danger" id="delete-rev">Delete</a>
   
  </div>
</div>
  
  <div id="gradebook" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  
      <h3>Gradebook</h3>
     
  </div>
  <div class="modal-body">
  <h3>THE GRADEBOOK IS INCOMPLETE</h3>
  <div class="row-fluid">
  <dl class="dl-horizontal span6">
  <dt>Current Grade</dt>
  <dd>97.1%</dd>
  <dt>Course Completion</dt>
  <dd>30.0%</dd>
  </dl>
  <dl class="dl-horizontal span6">
  <dt>Minimum Grade</dt>
  <dd>25.6%</dd>
  <dt>Maximum Grade</dt>
  <dd>99.2%</dd>
  </dl>
  </div>
  <div id="grade-list"></div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Close</a>
  </div>
</div>
<div id="final-project" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  
      <h3>About the  Final Project </h3>
     
  </div>
  <div class="modal-body"> 
  <dl class="dl-horizontal">
  <dt>Proposal Due Date</dt>
  <dd>4/1/2013</dd>
  <dt>Project Due Date</dt>
  <dd>5/12/2013</dd>
  <dt>Project Scope</dt>
  <dd>Create a website or web application that demonstrates your ability to implement at least six of the lessons presented in this class, in an integrated and logical way. </dd>
  <dt>HTML5 Page Structure<br>
10 points</dt><dd> The website needs to be structured semantically, using current document and metadata markup.</dd> <dt>Interactivity<br>
45 points</dt> <dd> The website needs to provide some way of interacting with the user - either through form elements, services such as  geolocation or data apis, or visual interactions using media or vector elements. </dd> <dt>Responsive Layout<br>
25 points</dt>  <dd>  The website page layouts must be designed for at least 2 screen-widths  using basic HTML5 viewport and media query capabilities.  </dd>
<dt>Overall Concept & Execution<br>
20 points</dt>  <dd>How innovative is your website concept and how fully realized is it the project. </dd>
</dl>
  <div id="project-list"></div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Close</a>
  </div>
</div>
 <div id="write-review" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  
    <h3><i id="review-grade"></i> for <span id="review-subject"></span> </h3>
     
  </div>
  <div class="modal-body"> 
   <p class="span5"> Comment </p>
 <p  class="span5"> <textarea columns=600 rows=2 id="review-comment" name="review-comment"></textarea></p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Close</a>
    <a class="btn btn-warning" id="submit-review">Submit</a>
  </div>
</div>
 
 <div id="myprofile" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h1 id="fullname"></h1>
    <p id="studentid"></p>
  </div>
  <div class="modal-body"> 
  <p class="span5">Your github.com userid </p>
  <p id="githubaccount" class="span5" contenteditable=true></p>
   <p class="span5">Your student gallery URL</p>
  <p id="galleryurl" class="span5" contenteditable=true></p>
     <p class="span5">Your final project proposal</p>
 <p class="span5"> <textarea columns=600 rows=2 id="myproject" name="myproject" ></textarea></p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Close</a>
    <a class="btn btn-warning" id="update-profile">Save changes</a>
  </div>
</div>

<div id="viewprofile" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h1 id="studentname" class="span3"></h1> <img id="studentavatar" class="img-polaroid" />
    <p id="studentemail"></p>
  </div>
  <div class="modal-body">  
  <h4 class="span5">On Github </h4>
  <p id="studentgithub" class="span5"></p>
   <h4 class="span5">Portfolio </h4>
  <p id="studentgalleryurl" class="span5"></p>
   <h4 class="span5">Final Project Proposal</h4>
  <p id="projectdesc" class="span5"></p>  
  <h4 class="span5">Exercises</h4>
  <div id="homeworks" class="span5"></div>  
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Close</a>
  </div>
</div>

<div id="view-homework" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>View exercise submission</h3>
  </div>
  <div class="modal-body" id="homework-content"></div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Close</a>
  </div>
</div>

<div id="submit-homework" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Submit your exercise information</h3>
  </div>
  <form class="modal-body" id="exercise-content"></form>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Close</a>
    <a class="btn btn-warning" id="submit-exercise">Submit</a>
  </div>
</div>

<nav class="row">
<div class="span12">
<ul class="nav nav-pills">
<!--
  <li><a href="http://diveintohtml5.info/">Dive into HTML5</a></li>
  <li><a href="web-programming/">CS 53.11B</a></li>
  <li><a href="wiki/">Wiki</a></li>
  <li><a href="glossary/">Glossary Essay</a></li>
-->
<?php
$result = $mysqli->query("SELECT text, url FROM nav_item WHERE syllabus_syllabus_id=" . $syllabus_id . " ORDER BY position");
while ( $row = $result->fetch_row() )
	print '  <li><a href="' . $row[1] . '">' . $row[0] . '</a></li>';
$result->close(); // Close the result
$mysqli->close(); // Close the connection
?>
  <li><a href="#" data-toggle="modal" data-target="#gradebook">Gradebook</a></li>
  <!--<li><a href="#" data-toggle="modal" data-target="#final-project">Final Project</a></li>-->
  <li><a href="#" id="profile" data-toggle="modal" data-target="#myprofile">Profile</a></li>
  <li><a href="#" id="logout">Logout</a></li>
</ul>
</div>
</nav>

  <div class="row">
    <div class="span4">  
    <h3>Lessons</h3>
    <table id="lesson-list" class="table table-striped">
  <tr>
    <th scope="col">Date</th>
    <th scope="col">Topic</th>
  </tr>
    </table>   
     <h3>Participants</h3>
      <div id="student-list"></div>
    </div>
     <div class="span8"> 
      <h1 id="lesson-topic"></h1>
       <p class="lead" id="lesson-desc"></p>
   <div id="lesson-info"> </div>
    </div>
    
    </div>  
  
<div id="general-info-hdr" class="row jumbotron subhead">
<div class="span12">
<h2>General Course Information <span style="font-size:80%;font-style:italic">(click to collapse)</span></h2>
</div>
</div>
<div class="row"  id="general-info">
<?php if ( $syllabus_id > 0 ) include( "syllabi/" . $uri[ 0 ] . ".html" ); ?>
</div>
<div class="row comments">
        <div class="span12">
        <h3 class="jumbotron subhead">Discussion Forum</h3>
        <p>Please use this discussion form appropriately to ask questions of the instructor or to share information that is of interest to the class.</p>
        <div id="disqus_thread"></div>
        <script type="text/javascript">
            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
            var disqus_shortname = 'javascriptcs5511'; // required: replace example with your forum shortname

            /* * * DON'T EDIT BELOW THIS LINE * * */
            (function() {
                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
        
        </div>
        </div>
         <footer class="row well well-large">
        <h4>This page requires Javascript and is best viewed in the  <a href="https://www.google.com/intl/en/chrome/browser/">latest version of Google Chrome
       <img src="<?php echo $root_path; ?>images/chrome.png" alt="Download Google Chrome" height="100" width="100" /></a></h4>
        </footer>
</div>
</body>
</html>
