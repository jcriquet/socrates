<?php 
require('../authenticate.php');
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Web Development Wiki | Jay Peretz | Santa Rosa Junior College</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="https://login.persona.org/include.js"></script>
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../css/spring2013.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
var user = '<?php print $_SESSION['user']['email'] ?>';
</script>
<script src="wiki.js"></script>
</head>

<body>
<header class="jumbotron subhead" id="overview">
  <div class="container">
  
   <h2 class="page-header">Web Development Wiki</h2>
  </div>
</header>
<div class="container">
<div id="update-definition" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  
    <h3>Update Your Definition</h3>
     
  </div>
  <div class="modal-body"> 
  
  <h3 id="change-term" class="span5"></h3>
   <p class="span5"> Definition </p>
 <p  class="span5"> <textarea columns=600 rows=2 id="new-definition"></textarea></p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Close</a>
     <a class="btn btn-danger" id="delete-definition">Delete</a>
    <a class="btn btn-warning" id="change-definition">Update</a>
  </div>
</div>
<div id="write-definition" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  
    <h3>Add or Edit a Web Term Definition </h3>
     
  </div>
  <div class="modal-body"> 
  <p class="span5">Web Term </p>
  <p id="enter-term" class="span5" contenteditable=true></p>
   <p class="span5"> Definition </p>
 <p  class="span5"> <textarea columns=600 rows=2 id="enter-definition"></textarea></p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Close</a>
    <a class="btn btn-warning" id="submit-definition">Submit</a>
  </div>
</div>
<nav class="row">
<div class="span12">
<ul class="nav nav-pills">
   <li><a href="../html5/">CS 52.10</a></li>
    <li><a href="../web-programming/">CS 53.11B</a></li>
     <li><a href="../glossary/">Glossary Essay</a></li>
</ul>
</div>
</nav>

  <div class="row">
 <div class="span8">
 <div class="row">
 <h3>Glossary of Terms</h3>
 <p><strong>Note:</strong> Please do not enter HTML tags directly into the definition or term.   Is is easiers if you just enter element names in all CAPS.   If you insist on displaying an HTML tag, you must use the HTML character codes for the opening and closing angle brackets, and wrap all code within CODE tags. </p>
  <button class="btn btn-large span3" type="button" id="add-definition" data-toggle="modal" data-target="#write-definition">Add or Amend a Term</button>
 </div>
 <div id="glossary"></div>
 
 </div>
    <div class="span4">
 
  <h3>Online References</h3>
 <div id="references"></div>
  
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