$(document).ready(function() {	  
	$("textarea#inputBlog").tinymce({
        // General options
       // mode : "textareas",
	    script_url : '../tinymce/jscripts/tiny_mce/tiny_mce.js',
        convert_urls : false,
        theme : "advanced",
        plugins : "autolink,lists,table,emotions,inlinepopups,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
        // Theme options
        theme_advanced_buttons1 :"bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,bullist,numlist",
        theme_advanced_buttons2 : "formatselect,outdent,indent,blockquote,|,link,unlink,anchor",
        theme_advanced_buttons3 :"image,code,tablecontrols,|,hr,emotions",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
        skin : "o2k7",
        skin_variant : "silver",
        template_replace_values : {
                username : "Some User",
                staffid : "991234"
        }
    });
	 $.ajax({
       type: "GET",
       url: "get-syllabi.php",
       datatype: "json"
      }).done(function( data) {
         data = $.parseJSON(data);	 
		  $.each(data, function(index, value) {
			  $("#syllabus-menu").append('<button class="btn btn-large selectClass span2" data-ID="'+value.syllabus_id+'" type="button">'+value.srjc_id+'</button>');		   
		  });
		  $("#syllabus-menu > button:first-child").addClass("btn-success");
		  $(".selectClass").click(function() {
			  $(".selectClass").removeClass("btn-success");
			  $(this).addClass("btn-success");
			  syllabus_id = $(this).attr("data-ID");
			  $(".lesson-listing").remove();
			  $("#newLesson").parent().parent().remove();
			  $("#readingList ,#exerciseList ,#exploreList ").html("");
			  showSyllabus(syllabus_id);
		  });
	  });	
	  $("#logout").click(function() {
		  navigator.id.logout();
		 
	  });
	  navigator.id.watch({
				loggedInUser: null,
				onlogin: function (assertion) {
					},
				// This won't ever fire in the example.
				onlogout: function () {
					 $.ajax({
            type: "GET",
            url: "../xanthippe/service/auth/index.php"
         }).done(function( data) {
			 document.location.reload();
	  });
					}
			});
	$('#studentid').text(user);
	
	showSyllabus(syllabus_id);

	
	});

//  function to build a full class with all lessons
var showSyllabus = function(syllabus_id) {
	var currentLesson = 1;
	var syllabus;	 
    $.ajax({
       type: "GET",
       url: "lesson-maker.php",
       data: { syllabus_id: syllabus_id },
       datatype: "json"
      }).done(function( data) {
         data = $.parseJSON(data);
         syllabus = data[syllabus_id];
		 $("#course-info").html(syllabus.course_name+"&nbsp;|&nbsp;"+syllabus.srjc_id+"&nbsp;|&nbsp; Section "+syllabus.section_number);
		 $.each(syllabus.lessons, function(index, value) {
			 $("#lesson-list").append("<tr class=lesson-listing data-id="+value.lesson_id+"><td>"+value.lesson_date.substr(0,value.lesson_date.indexOf(","))+"</td><td>"+value.topics+"</td></tr>");
		 });
		 $("#lesson-list").append('<tr><td><p id="newlessondate" contenteditable></p></td><td><p id="newlessontopic" contenteditable></p></td><td><button id="newLesson" class="btn" type="button">Add</button></td></tr>');
		 $("#newLesson").click(function() {
			 $.ajax({
                      type: "POST",
                      url: "update-lesson.php", 
					  data: { topics:$("#newlessontopic").text(), lesson_date: $("#newlessondate").text() , syllabus_id:syllabus_id }
					}).done(function(data) {
						  alert("New Lesson Added");
						  data = $.parseJSON(data);
						syllabus.lessons[data.lesson_id] = data;
						$("#newlessontopic , #newlessondate").html("");
						$("#lesson-list tr:last").before("<tr class=lesson-listing data-id="+data.lesson_id+"><td>"+data.lesson_date.substr(0,data.lesson_date.indexOf(","))+"</td><td>"+data.topics+"</td></tr>");
						$(".lesson-listing[data-id="+data.lesson_id+"]").click(function() {
						showLesson(data.lesson_id);	
						});;
						
						
					  });
		   });
		
		 $(".lesson-listing").click(function() {
			 showLesson($(this).attr("data-id"));	
			 $(".lesson-listing").removeClass("info");
			 $(this).addClass("info");	
			 $("#saveLesson").parent().remove();
			 $(this).append('<td><button id="saveLesson" class="btn btn-primary" type="button">Save</button></td>');
			 setSaveBtn();
	     });
		 showLesson($("table#lesson-list tbody tr").eq(currentLesson).attr("data-id"));
		 $("table#lesson-list tbody tr").eq(currentLesson).addClass("info");
		 $("table#lesson-list tbody tr").eq(currentLesson).append('<td><button id="saveLesson" class="btn btn-primary" type="button">Save</button></td>');	
		 setSaveBtn();
        });
		
		// the function that dislays the information for a specific lesson
	   function showLesson(lessonID) {
		   
	    $("#lesson-topic").html(syllabus.lessons[lessonID].topics);
		$("#lesson-desc").html(syllabus.lessons[lessonID].description);		
		if ($('#inputBlog').html()) {
			$('#inputBlog').html("")
			if (syllabus.lessons[lessonID].blogpost) {
    	        $('#inputBlog').tinymce().execCommand('mceReplaceContent',false,syllabus.lessons[lessonID].blogpost);
			} else {
				 $('#inputBlog').tinymce().execCommand('mceReplaceContent',false,"Enter a Post");
			};
		} else {
		  $('#inputBlog').html(syllabus.lessons[lessonID].blogpost);
		};				
		$("#readingList").html("");
		$("#exerciseList").html("");
		$("#exploreList").html("");
		//set up the reading list
		if (syllabus.lessons[lessonID].reads) {			
		$.each(syllabus.lessons[lessonID].reads, function(index, value) {	
		    $("#readingList").append("<div class=row data-readID="+syllabus.lessons[lessonID].reads[index].read_id+"></div>");				
			if (syllabus.lessons[lessonID].reads[index].title) {
			$("#readingList > div").last().append('<p class="span2">'+syllabus.lessons[lessonID].reads[index].title+'</p>');
			} else {
			$("#readingList > div").last().append('<p class="span2"></p>');
			}
			$("#readingList > div").last().append('<p class="reading-description span2" contenteditable=true>'+syllabus.lessons[lessonID].reads[index].description+'</p>');
			$("#readingList > div").last().append('<p class="reading-url span3" contenteditable=true>'+syllabus.lessons[lessonID].reads[index].reading_url+'</p>');
			$("#readingList > div").last().append('<button class="btn btn-primary readingSave span1" type="button">Save</button>');
	      });
		  // updating a reading assigment
		 $(".readingSave").click(function() {
		     syllabus.lessons[lessonID].reads[$(this).parent().attr("data-readID")].description = strip($(this).siblings(".reading-description").text());
		     syllabus.lessons[lessonID].reads[$(this).parent().attr("data-readID")].reading_url = strip($(this).siblings(".reading-url").text());
			$.ajax({
                      type: "GET",
                      url: "put-reading.php",
                      data: { reading_id: syllabus.lessons[lessonID].reads[$(this).parent().attr("data-readID")]},
                      datatype: "json"
                      }).done(function( data) {
				         alert("Reading Assignment Updated");
			 });
		  });	
		}
            $("#readingList").append("<div class=row></div>");
			$("#readingList > div").last().append('<p class="span2 reading-list"> </p>');
			$("#readingList > div").last().append('<p class="span2 reading-description" contenteditable=true> </p>');
			$("#readingList > div").last().append('<p class="span3 reading-url" contenteditable=true></p>');
			$("#readingList > div").last().append('<button class="btn readingAdd span1" type="button">Add</button>');
			//adding a new reading assignment
			$(".readingAdd").click(function() {
			var newReading = {lesson_id: lessonID,resource_id:$(this).parent().children(".reading-list").children("select").val(),description:$(this).parent().children(".reading-description").text(),reading_url:strip($(this).parent().children(".reading-url").text())};
			$(this).parent().children(".reading-description").html("");
			$(this).parent().children(".reading-url").html("");
			$.ajax({
                      type: "GET",
                      url: "put-reading.php",
                      data: newReading ,
                      datatype: "json"
                      }).done(function( data) {
				         alert("Reading Assignment Added");
					     data = $.parseJSON(data);
						 if (!syllabus.lessons[lessonID].reads) {
							 syllabus.lessons[lessonID].reads = {};
						 }
						 syllabus.lessons[lessonID].reads[data.read_id] = {description:data.description,reading_url:data.reading_url};
						 $("#readingList > div:last").before("<div class=row data-readID="+data.read_id+"></div>");
						 if (data.title) {
						 $("#readingList > div[data-readID="+data.read_id+"]").append('<p class="span2">'+data.title+'</p>');
						 } else {
						 $("#readingList > div[data-readID="+data.read_id+"]").append('<p class="span2"></p>');
						 }
			             $("#readingList > div[data-readID="+data.read_id+"]").append('<p class="reading-description span2" contenteditable=true>'+data.description+'</p>');
			             $("#readingList > div[data-readID="+data.read_id+"]").append('<p class="reading-url span3" contenteditable=true>'+data.reading_url+'</p>');
			             $("#readingList > div[data-readID="+data.read_id+"]").append('<button class="btn btn-primary readingSave span1" type="button">Save</button>');	
			 });
		  });	
		  // get resources for book dropdown
	  $.ajax({
       type: "GET",
       url: "get-resources.php",
       datatype: "json"
      }).done(function( data) {
         data = $.parseJSON(data);	
		 var booklist = '<select value="" style="width:150px"><option value="">None</option>'
		 $.each(data, function(index, value) {
			 booklist += '<option value="'+value.resource_id+'">'+value.title+'</option>';
		 });
		  booklist += '</select>';
		 $(".reading-list").append(booklist);
	  });	 	 
		  //set up the exercise list 
		if (syllabus.lessons[lessonID].exercises) {			
		$.each(syllabus.lessons[lessonID].exercises, function(index, value) {	
		    $("#exerciseList").append("<div class=row data-ID="+syllabus.lessons[lessonID].exercises[index].exercise_id+"></div>");	
			$("#exerciseList > div").last().append('<p class="exercise-description span3" contenteditable=true>'+syllabus.lessons[lessonID].exercises[index].description+'</p>');
			$("#exerciseList > div").last().append('<p class="exercise-url span4" contenteditable=true>'+syllabus.lessons[lessonID].exercises[index].url+'</p>');
			$("#exerciseList > div").last().append('<button class="btn btn-primary exerciseSave span1" type="button">Save</button>');
	      });
		 $(".exerciseSave").click(function() {
		     syllabus.lessons[lessonID].exercises[$(this).parent().attr("data-ID")].description = strip($(this).siblings(".exercise-description").text());
		     syllabus.lessons[lessonID].exercises[$(this).parent().attr("data-ID")].url = strip($(this).siblings(".exercise-url").text());
			$.ajax({
                      type: "GET",
                      url: "put-exercise.php",
                      data: { exercise_id: syllabus.lessons[lessonID].exercises[$(this).parent().attr("data-ID")]},
                      datatype: "json"
                      }).done(function( data) {
				         alert("Exercise Assignment Updated");
			 });
		  });	
		}
            $("#exerciseList").append("<div class=row></div>");
			$("#exerciseList > div").last().append('<p class="span3 exercise-description" contenteditable=true> </p>');
			$("#exerciseList > div").last().append('<p class="span4 exercise-url" contenteditable=true></p>');
			$("#exerciseList > div").last().append('<button class="btn exerciseAdd span1" type="button">Add</button>');
			$(".exerciseAdd").click(function() {
			var newExercise = {lesson_id: lessonID,description:strip($(this).parent().children(".exercise-description").text()), url:strip($(this).parent().children(".exercise-url").text())};
			$(this).parent().children(".exercise-description").html("");
			$(this).parent().children(".exercise-url").html("");
			$.ajax({
                      type: "GET",
                      url: "put-exercise.php",
                      data: newExercise ,
                      datatype: "json"
                      }).done(function( data) {
				         alert("Exercise Assignment Added");
					     data = $.parseJSON(data);
						 if (!syllabus.lessons[lessonID].exercises) {
							 syllabus.lessons[lessonID].exercises = {};
						 }
						 syllabus.lessons[lessonID].exercises[data.exercise_id] = {description:data.description,url:data.url};
						 $("#exerciseList > div:last").before("<div class=row data-ID="+data.exercise_id+"></div>");
			             $("#exerciseList > div[data-ID="+data.exercise_id+"]").append('<p class="exercise-description span3" contenteditable=true>'+data.description+'</p>');
			             $("#exerciseList > div[data-ID="+data.exercise_id+"]").append('<p class="exercise-url span4" contenteditable=true>'+data.url+'</p>');
			             $("#exerciseList > div[data-ID="+data.exercise_id+"]").append('<button class="btn btn-primary exerciseSave span1" type="button">Save</button>');	
			 });
		  });		
		  //set up the explore list 
		if (syllabus.lessons[lessonID].explores) {
		$.each(syllabus.lessons[lessonID].explores, function(index, value) {	
		    $("#exploreList").append("<div class=row data-ID="+syllabus.lessons[lessonID].explores[index].explore_id+"></div>");	
			$("#exploreList > div").last().append('<p class="explore-description span3" contenteditable=true>'+syllabus.lessons[lessonID].explores[index].description+'</p>');
			$("#exploreList > div").last().append('<p class="explore-url span4" contenteditable=true>'+syllabus.lessons[lessonID].explores[index].url+'</p>');
			$("#exploreList > div").last().append('<button class="btn btn-primary exploreSave span1" type="button">Save</button>');
	      });
		 $(".exploreSave").click(function() {
		     syllabus.lessons[lessonID].explores[$(this).parent().attr("data-ID")].description = strip($(this).siblings(".explore-description").text());
		     syllabus.lessons[lessonID].explores[$(this).parent().attr("data-ID")].url = strip($(this).siblings(".explore-url").text());
			$.ajax({
                      type: "GET",
                      url: "put-explore.php",
                      data: { explore_id: syllabus.lessons[lessonID].explores[$(this).parent().attr("data-ID")]},
                      datatype: "json"
                      }).done(function( data) {
				         alert("Explore Assignment Updated");
			 });
		  });	
		}
            $("#exploreList").append("<div class=row></div>");
			$("#exploreList > div").last().append('<p class="span3 explore-description" contenteditable=true> </p>');
			$("#exploreList > div").last().append('<p class="span4 explore-url" contenteditable=true></p>');
			$("#exploreList > div").last().append('<button class="btn exploreAdd span1" type="button">Add</button>');
			$(".exploreAdd").click(function() {
			var newExplore = {lesson_id: lessonID,description:strip($(this).parent().children(".explore-description").text()), url:strip($(this).parent().children(".explore-url").text())};
			$(this).parent().children(".explore-description").html("");
			$(this).parent().children(".explore-url").html("");
			$.ajax({
                      type: "GET",
                      url: "put-explore.php",
                      data: newExplore ,
                      datatype: "json"
                      }).done(function( data) {
				         alert("Explore Assignment Added");
					     data = $.parseJSON(data);
						 if (!syllabus.lessons[lessonID].explores) {
							 syllabus.lessons[lessonID].explores = {};
						 }
						 syllabus.lessons[lessonID].explores[data.explore_id] = {description:data.description,url:data.url};
						 $("#exploreList > div:last").before("<div class=row data-ID="+data.explore_id+"></div>");
			             $("#exploreList > div[data-ID="+data.explore_id+"]").append('<p class="explore-description span3" contenteditable=true>'+data.description+'</p>');
			             $("#exploreList > div[data-ID="+data.explore_id+"]").append('<p class="explore-url span4" contenteditable=true>'+data.url+'</p>');
			             $("#exploreList > div[data-ID="+data.explore_id+"]").append('<button class="btn btn-primary exploreSave span1" type="button">Save</button>');	
			 });
		  });
		
		
    }
	function setSaveBtn() {
		 $("#saveLesson").click(function() {
		     syllabus.lessons[$(this).parent().parent().attr("data-id")].topics = $("#lesson-topic").text();
		     syllabus.lessons[$(this).parent().parent().attr("data-id")].description = $("#lesson-desc").text();
			 syllabus.lessons[$(this).parent().parent().attr("data-id")].blogpost = $('#inputBlog').html();
			$.ajax({
                      type: "POST",
                      url: "update-lesson.php",
                      data: { lesson_id: syllabus.lessons[$(this).parent().parent().attr("data-id")]},
                      datatype: "json"
                      }).done(function( data) {
				         alert("Lesson Updated");
			 });
		  });	 
	}  
	// remove potential residual tags in href input fields
	function strip(html) {
       var tmp = document.createElement("DIV");
       tmp.innerHTML = html;
       return tmp.textContent || tmp.innerText;
    } 

}