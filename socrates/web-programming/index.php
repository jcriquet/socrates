<?php 
require('../authenticate.php');
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Jay Peretz | SRJC Spring 2013 | HTML5 Web Programming</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script src="https://login.persona.org/include.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../css/spring2013.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
var user = '<?php print $_SESSION['user']['email'] ?>';
var syllabus_id = 2;
var currentLesson = 8;
</script>
<script src="../js/jquery.mobile.custom.min.js"></script>
<script src="../js/spring2013.js"></script>
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
  <dd>Create a Database-Driven Website using PHP & MySQL, with an application of your choice.    There are SO many applications you can choose, for example: a TO-DO list, a recipe book, a catalog of your music, a contact list of your friends that automatically sends e-birthday & e-holiday cards, a specialized blog or content management system (such as this class webpage)...</dd> 
  <dt>Database Interaction<br>
30 points</dt><dd> The website needs to demonstrate the ability to interact with data in a database using the PHP - AJAX - Javascript techniques demonstrated in the class tutorials.</dd> <dt>Database Design<br>
25 points</dt> <dd> The database needs to be designed using the entity-relationship constraints we explored in the SQL tutorials (ie not in one table). </dd> <dt>Responsive Layout<br>
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
   <p class="span5"> Your student gallery URL </p>
  <p id="galleryurl" class="span5" contenteditable=true></p>
     <p class="span5"> Your final project proposal </p>
 <p  class="span5"> <textarea columns=600 rows=2 id="myproject" name="myproject"></textarea></p>
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

<div id="submit-homework" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  
    <h3>Submit your exercise information</h3>
  
  </div>
  <div class="modal-body"> 
  <p class="span5">URL of page </p>
  <p id="exercise-link" class="span5" contenteditable=true></p>
   <p class="span5"> Comment </p>
 <p  class="span5"> <textarea columns=600 rows=2 id="exercise-comment" name="exercise-comment"></textarea></p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Close</a>
    <a class="btn btn-warning" id="submit-exercise">Submit</a>
  </div>
</div>

<nav class="row">
<div class="span12">
<ul class="nav nav-pills">
  <li><a href="http://www.w3schools.com/php/default.asp">PHP/MySQL/AJAX Tutorial</a></li>
  <li><a href="https://sas.elluminate.com/site/external/recording/playback/link/table/meeting?suid=M.DE63425940BCC831A6EEBAF99817AC">Elluminate Archive</a></li>
    <li><a href="../html5/">CS 52.10</a></li>
   <li><a href="http://online.santarosa.edu/gradebook/?5042">Gradebook</a></li>
   <li><a href="../wiki/">Wiki</a></li>
     <li><a href="../glossary/">Glossary Essay</a></li>
    <li><a href="#" data-toggle="modal" data-target="#final-project">Final Project</a></li>
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
    <div class="span4">       
          <h3>Lecture/Labs</h3>
          
          
        <p>Wednesdays 7:00PM-10:00PM<br>
   Petaluma Campus Call Building Room PC643
</p><p>Class attendance is strongly encouraged but not required, all lectures will be broadcast and recorded.</p>
<h3>Live Broadcast</h3>
<p>Visit <a  href="http://www.cccconfer.org/">www.cccconfer.org</a> <br>
  Click the Student Log-In button under the <strong>Teach & Confer logo</strong><br>
  Locate your meeting and click Go
  Fill out the form and enter the passcode: 882585</p>
  <p>Watch the <a  href="https://sas.elluminate.com/site/external/recording/playback/link/table/meeting?suid=M.DE63425940BCC831A6EEBAF99817AC">Class Lecture Archives</a> on Elluminate Blackboard</p>
  
<h3>Office Hours</h3>
<p>Wednesdays 6:00PM-7:00PM<br>
  Petaluma Campus Call Building   Computer Lab<br>
  By Appointment Only
  <br>
</p>
<h3>Class Forum</h3>
<p>The discussion forum below is the appropriate place to post questions and comments about the class materials or process that would pertinent to other students in the class. Please check the discussion board first if you have a question.     Students should  create a profile on <a  href="http://www.disqus.com/">Disqus</a>  to follow discussions by email.   Exceptional community citizenship on the class discussion board can be worth up to 5 points of extra credit in the class. </p>

<h3>Gradebook</h3>
<p>Check your grades for exams and projects:</p> 
<p>  
<a  href="http://online.santarosa.edu/gradebook/?5042">Gradebook</a> for  section 5250</a>  
</p>

          
            <h4>Official Course Catalog Description</h4>
          <p>An exploration of advanced topics in Dreamweaver with an emphasis on building dynamic web pages using Cascading Style Sheets (CSS), Spry (the Adobe implementation of Ajax) and other JavaScript frameworks, and the open source server-side technology PHP and MySQL databases.</p>
          <h4>Student Learning Outcomes</h4>
        
<p>Students will be able to:<br>
1.  Demonstrate the efficient use of Dreamweaver tools to create a web pages that adhere to current HTML  (hypertext markup language) and CSS (Cascading Style Sheets) standards.<br>
2.  Incorporate a variety of dynamic client and server-sided technologies including the use of Asynchronous JavaScript and XML (AJAX), the creation of sever-validated forms, the implementation of templates, and the use of PHP [Hypertext Preprocessor] and MySQL [Simple Query Language]  to construct database-driven web sites.</p>

<h4>Required Materials</h4>
<p>Adobe Dreamweaver CS5 or higher</p>
           <!--<p>There is NO REQUIRED SOFTWARE, although you will need a good code editor and a webserver account (an SRJC student account is fine, but you may also use your own domain or another host.) You will also need to use a current version of an HTML5 browser with a great element inspector (Chrome, FireFox, Opera or Internet Explorer 9+ will work.)</p>-->
<p>A webserver account, either on your own domain or <a  href="https://student.santarosa.edu:85/apply/linux-account.php">free Linux webserver accounts</a> are available through the Santa Rosa Junior College IT services. </p>
<p>You may use the Computer Studies labs in Santa Rosa and Petaluma during regularly scheduled lab hours, or you may also work at your own computer. You MUST be self-sufficient with basic webserver fundamentals and be able to use FTP to deploy a website.</p>
<p>An account on <a  href="http://www.github.com/">github.com</a> for your project and exercise code repositories.   This will be discussed in class.</p>
     </div>
    <div class="span4"> 
        <h4>Textbook</h4> 
        
           <p>This class has no REQUIRED textbook.   The material will be covered completely in the lectures (live and recorded), exercises supplemental resources that will presented as part of each weekly lecture.    </p>
       

   
    <p>These optional textbooks may be also be useful to some students based on learning style or focus area.</p>
    <ul>
     
     
      <li><a href="http://www.amazon.com/Learning-MySQL-JavaScript-Step--ebook/dp/B008XCFLTM/ref=sr_1_1?s=digital-text&ie=UTF8&qid=1357777372&sr=1-1&keywords=php+mysql">Learning PHP, MySQL, JavaScript, and CSS: A Step-by-Step Guide to Creating Dynamic Websites by Robin Nixon</a></li>
       <li><a href="http://www.amazon.com/MySQL-Dynamic-Fourth-Edition-ebook/dp/B005GXM63U/ref=sr_1_3?s=digital-text&ie=UTF8&qid=1357777372&sr=1-3&keywords=php+mysql">PHP and MySQL for Dynamic Web Sites, Fourth Edition: Visual QuickPro Guide by Larry Ullman</a></li>
       <li><a href="http://www.lynda.com/Dreamweaver-CS5-tutorials/php-and-mysql/68620-2.html?srchtrk=index%3a4%0alinktypeid%3a2%0aq%3amysql+php%0apage%3a1%0as%3arelevance%0asa%3atrue%0aproducttypeid%3a2">lynda.com: Dreamweaver with PHP and MySQL with David Gassner</a></li>
    </ul>
  
  
    <h4>About the Instructor</h4>
<p>Jay Peretz is a part time Adjunct Faculty member in Computer Studies at <a href="http://www.santarosa.edu/">Santa Rosa Junior College</a>.   Jay teaches web development classes in HTML, CSS, Javascript, Dreamweaver, Flash, PHP, SQL, XML and Actionscript.</p>
<p>Phone: (Computer Studies Dept Desk) 707-527-4778</p>
<p>Email: <a href="mailto:jperetz@santarosa.edu">jperetz@santarosa.edu</a></p>
<p>Email policy - questions regarding class material, projects and assignment are best researched and posted on the class forum, where instructors and other students may be of assistance.   Emails sent directly to the instructor will generally be reviewed within 24 hours.   </p>
          
           <h4>Grading Policy </h4>
 <p>Your final grade will be based on the following:</p>
<table width="95%"  class="table table-striped">
  <tr>
    <th scope="col">Assignment</th>
    
    <th scope="col">Points</th>
  </tr>
  <tr>
    <td>Final Project</td>
    
    <td>40</td>
  </tr>
  
  <tr>
    <td>Midterm Exam</td>
  
    <td>20</td>
  </tr>
  <tr>
    <td>Final Exam</td>
  
    <td>20</td>
  </tr>
  <tr>
    <td>Participation and Exercises</td>
  
    <td>20</td>
  </tr>
  <tr>
    <td>Total</td>
    
    <td>100</td>
  </tr>
</table>
<ul><li>91% -100% = A</li>
<li>81% -9 0% = B</li>
<li>71% - 80% = C</li>
<li>65% - 70% = D</li>
<li>&lt;65 = F</li></ul>

  <h4>Exams</h4>
  <p>There will be  online midterm and final
    exams. The material comes from the class lectures and supplemental materials. If any exam is missed, a zero will be recorded as the score. It is your responsibility
    to take the online exams by the due date.</p>
  <h4>Projects</h4>
  <p>You must submit a final project by the posted due date for a passing grade.   The project will be a comprehensive website demonstrating the techniques taught in the class and developed in the class exercises in each weekly lesson.</p>
  <h4>Credit-No Credit</h4>
  <p>This class may be taken for either a grade or the P/NP option.</p>
  <h4>Dropping the Class</h4>
  <p>If you decide to discontinue this course, it is your responsibility to officially drop it to avoid
    getting no refund (after 10% of course length), a W symbol (after 20%), or a grade (after
    60%). Also, for several consecutive, unexplained absences, the instructor may drop a
    student.</p> 
    </div>
    <div class="span4">
    <h4>Semester Schedule</h4>
 	 <table  class="table table-striped" >
		<tbody><tr>
			<td>Date Class Begins: </td><td>1/16/2013</td><td>Date Class Ends: </td><td>5/15/2013</td>
		</tr><tr>
			<td>Last Day Add w/o add code: </td><td>1/20/2013</td><td>Last Day Add with add code: </td><td>2/3/2013</td>
		</tr><tr>
			<td>Last Day Drop for Refund: </td><td>1/27/2013</td><td>Last Day for P/NP option: </td><td>2/24/2013</td>
		</tr><tr>
			<td>Last Day Drop w/o W: </td><td>2/3/2013</td><td>Last Day Drop with W: </td><td>4/21/2013</td>
		</tr><tr>
			<td class="NormalBold">FIRST CENSUS DATE: </td><td>2/4/2013</td><td>Date Final Exam: </td><td>5/22/2013</td>
		</tr>
	</tbody></table>	
	
	 	
	
 	 	



<h4>Cell Phones and Text Messaging</h4>

<p>Calls or text messaging are not permitted in classroom or lab. See instructor if you have an
emergency situation.</p>
<h4>Standards of Conduct</h4>
<p>Students shall conduct themselves in a manner that reflects their awareness of common
standards of decency and the rights of others. Interference with SRJC's educational
objectives is a cause for disciplinary action. All members of the college community are
expected to refrain from such interference, including the following types of conduct:</p>
<ul>
<li>Disruption of teaching</li>
<li>Dishonesty, cheating, plagiarism</li>
<li>Physical or verbal abuse</li>
<li>Disorderly, lewd, indecent, or obscene conduct</li>
</ul>


<h4>Email Etiquette</h4>

<p>Here is a list of some basic guidelines for using the class forum or emailing directly to the
instructor or a classmate:</p>

<ul><li>Email can easily be misinterpreted; be brief, polite, never send email when angry.</li>
<li>Always include a pertinent subject title for the message.</li>
<li>Capitalize words only to highlight an important point or to distinguish a title or
heading. Capitalizing whole words is termed as SHOUTING!</li>
<li>It is rude to forward personal email without the author's permission</li></ul>


<h4>Special Needs</h4>
<p>Students with disabilities who believe they need accommodations in this class are
encouraged to contact Disability Resources (527-4278), Analy Village - C, as soon as
possible to better ensure such accommodations are implemented in a timely fashion.</p>
</div>
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
       <img src="../images/chrome.png" alt="Download Google Chrome" height="100" width="100" /></a></h4>
        </footer>
</div>
</body>
</html>