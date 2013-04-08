<?php 
require('../authenticate.php');
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Glossary Essay | Jay Peretz | Santa Rosa Junior College</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="https://login.persona.org/include.js"></script>
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../css/spring2013.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
var user = '<?php print $_SESSION['user']['email'] ?>';
</script>
<script src="glossary.js"></script>
</head>

<body>
<header class="jumbotron subhead" id="overview">
  <div class="container">
  
   <h2 class="page-header">Glossary Essay Question</h2>
  </div>
</header>
<div class="container">
<nav class="row">
<div class="span12">
<ul class="nav nav-pills">
   <li><a href="../html5/">CS 52.10</a></li>
    <li><a href="../web-programming/">CS 53.11B</a></li>
     <li><a href="../wiki/">Wiki</a></li>
</ul>
</div>
</nav>

  <div class="row">
         <div class="span12">
         
           <div class="row"> 
            <div class="span12"><h3>Instructions</h3>  
            <p>This is a bit like musical definitions.  There are over 50 terms that can to be defined, more than enough for every student.  Each student chooses a term and writes a definition for that term.   Your definition will <a href="../wiki/index.php">appear in the class WIKI</a>.   Each definition should be at least two sentences long, consider it like an essay question.  Write the definition in your own words and in a way that is useful to the rest of the class.   Do not copy and paste from Wikipedia or another source.     Once a student selects a term, it is no longer available on this page for other students, so choosing your term early is an advantage.   Please only select and define one term on this page.</p><p>Once a term has been defined, other students can amend the definition on the <a href="../wiki/index.php">Wiki page</a>.   In addition, you can add new terms and definitions <a href="../wiki/index.php">on the Wiki page</a> beyond the terms listed here (credit for participation.)</p>
         <p><strong>Note:</strong> Please do not enter HTML tags directly into the definition or term.   Is is easiers if you just enter element names in all CAPS.   If you insist on displaying an HTML tag, you must use the HTML character codes for the opening and closing angle brackets, and wrap all code within CODE tags. </p>
            </div>
            </div> 
        
         
          <div class="row"> 
            <div class="span3"><h3>Choose a Term</h3> 
          		<select id="openterms">
                </select>
                </div>
                  <div class="span5">
                  <h3>Write a Definition</h3> 
          		<textarea rows="3" id="enter-definition" width="400"></textarea>
                </div>
                 <div class="span4">
          		<button class="btn btn-large btn-warning" type="button" id="add-definition">Submit</button>
                </div>
        
         </div>
         </div>
   
  </div>  
  
         <footer class="row well well-large">
        <h4>This page requires Javascript and is best viewed in the  <a href="https://www.google.com/intl/en/chrome/browser/">latest version of Google Chrome
       <img src="../images/chrome.png" alt="Download Google Chrome" height="100" width="100" /></a></h4>
        </footer>
</div>
</body>
</html>