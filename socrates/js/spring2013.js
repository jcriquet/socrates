$(document).ready(function() {
	var syllabus;
	$("#submit-homework , #update-homework , #update-review, #write-review").modal("hide");
	var getProfile = function(user) {
		$.ajax({
			type: "GET",
			url: getRootPath()+"lesson-maker/get-profile.php",
			data: { email: user, syllabus_id:syllabus_id },
			datatype: "json"
		}).done(function( data) {
			data = $.parseJSON(data);
			console.log(data);
			$('#fullname').text(data.first_name + " " + data.last_name);
			$("#mygravatar").attr("src","http://www.gravatar.com/avatar/"+data.gravatar_hash);
			if (data.gallery_URL) {
				$('#galleryurl').text(data.gallery_URL);
			}
			if (data.github_userid) {
				$('#githubaccount').text(data.github_userid);
			}	
			if (data.project_description) {
				$('#myproject').val(data.project_description);
			}		  
		});
	};
	function getRootPath() {
		var r = "";
		for ( var i = window.location.pathname.substring(scriptPath.length).split("/").length-1; i > 0; --i )
			r += "../";
		return r;
	}
	function listGrades() {
		var gradeList = "";
		$("#grade-list").html(gradeList);
		gradeList += '<table class="table table-condensed table-striped"><tbody>';
		$.each(syllabus.students,function(index,value) {
			if (syllabus.students[index].project_description) {
				projectList += '<tr><td>'+syllabus.students[index].first_name+'</td><td>'+syllabus.students[index].project_description+'</td></tr>';			
			} else {
				projectList += '<tr><td>'+syllabus.students[index].first_name+'</td><td></td></tr>';
			}
		});
		projectList += '</tbody></table>';
		$("#project-list").html(projectList);
	}
	function listProjects() {
		var projectList = "";
		$("#project-list").html(projectList);
		projectList += '<table class="table table-condensed table-striped"><tbody>';
		$.each(syllabus.students,function(index,value) {
			if (syllabus.students[index].project_description) {
				projectList += '<tr><td>'+syllabus.students[index].first_name+'</td><td>'+syllabus.students[index].project_description+'</td></tr>';			
			} else {
				projectList += '<tr><td>'+syllabus.students[index].first_name+'</td><td></td></tr>';
			}
		});
		projectList += '</tbody></table>';
		$("#project-list").html(projectList);
	}
	function showLesson(lessonID) {
		$.ajax({
			type: "GET",
			url: getRootPath()+"xanthippe/lesson.php",
			data: { lesson_id: lessonID },
			datatype: "json"
		}).done(function( data) {
			data = $.parseJSON(data);
			lesson = data[lessonID];
			console.log(lesson);
			$("#lesson-topic").html(lesson.topics);
			$("#lesson-desc").html(lesson.description);
			var lessoncontent = "";
			if (lesson.blogpost) {
				lessoncontent += "<div class=blog>"+lesson.blogpost+"</div>";
			};
			// display any reading assignments for this lesson
			if (lesson.reads) {
				lessoncontent += "<h2>Reading</h2>";
				$.each(lesson.reads, function(index, value) {
					if (lesson.reads[index].title && lesson.reads[index].reading_url) {
						lessoncontent += '<p><a href="'+lesson.reads[index].reading_url+'">'+lesson.reads[index].title+'&nbsp;'+lesson.reads[index].description+'</a></p>';
					} else if (!lesson.reads[index].title && lesson.reads[index].reading_url)  {
						lessoncontent += '<p><a href="'+lesson.reads[index].reading_url+'">'+lesson.reads[index].description+'</a></p>';
					} else if (lesson.reads[index].title && !lesson.reads[index].reading_url) {
						lessoncontent += '<p>'+lesson.reads[index].title+'&nbsp;'+lesson.reads[index].description+'</p>';
					} else {
						lessoncontent += '<p>'+lesson.reads[index].description+'</p>';
					}
				});
			}
			// display any explore links for this lesson
			if (lesson.explores) {
				lessoncontent += "<h2>Explore </h2>";
				lessoncontent += "<h4>Non-manditory readings and exercises.  Choose the ones that you find interesting.</h4>"; 
				$.each(lesson.explores, function(index, value) {
					lessoncontent += '<p><a href="'+lesson.explores[index].url+'">'+lesson.explores[index].description+'</a></p>';
				});
			}
			// display any exercises for this lesson
			if (lesson.exercises) {
				lessoncontent += "<h2>Exercises</h2>";
				$.each(lesson.exercises, function(index, value) {
					lessoncontent += '<p class="exercise"><a ';
					if (value.type != '') {
						lessoncontent += 'data-exercise="'+index+'" class="btn btn-mini submit-hw ';
						switch (value.type) {
							case 'test': lessoncontent += 'btn-success">Take'; break;
							case 'form': lessoncontent += 'btn-primary">Answer'; break;
							default: lessoncontent += 'btn-danger">Submit';
						}
					} else
						lessoncontent += 'class="btn btn-mini btn-inverse">&nbsp;';
					lessoncontent += '</a>&nbsp;';
					if (value.url) {
						lessoncontent += '<a href="'+value.url+'">'+value.description+'</a></p>';
					} else {
						lessoncontent += value.description+'</p>';
					}
					// display any homework submissions for this exercise
					if (value.homeworks) {
						$.each(value.homeworks,function(index2,value2) {
							lessoncontent += '<p class="muted"><a data-reviewee='+ value2.first_name+' data-homeworkid="'+ index2+'" class="btn btn-mini thumbs thumbsup" href="#write-review"><i class="icon-thumbs-up"></i></a><a data-reviewee='+ value2.first_name+'  data-homeworkid="'+ index2 +'"  class="btn btn-mini thumbs thumbsdown" href="#write-review"><i class="icon-thumbs-down"></i></a>&nbsp;&nbsp;'
							switch (value.type) {
								case "url":
									//does the submission have a url link
									lessoncontent += value2.URL ? '<a href="'+value2.URL+'">'+value2.first_name+'</a>' : value2.first_name;
									lessoncontent += '&mdash; '+(value2.comment ? value2.comment : '')+'&nbsp;';
									break;
								case "form":
									lessoncontent += '<a data-exercise="'+ index +'" data-homework="'+ index2 +'" class="view-hw">'+value2.first_name+'</a>';
									lessoncontent += '&mdash; ';
									//display the first non-empty field as the comment
									for (var value3 in value2.answers) {
										if (value2.answers[value3].text) {
											//limit to only 80 characters
											lessoncontent += value2.answers[value3].text.length > 80 ? value2.answers[value3].text.substring(0,80) + '...' : value2.answers[value3].text;
											break;
										}
									}
									lessoncontent += '&nbsp;';
									break;
								case "test":
									lessoncontent += '<a data-exercise="'+ index +'" data-homework="'+ index2 +'" class="view-hw">'+value2.first_name+'</a>&nbsp;';
									break;
							}
							// is this submission by the current logged in user
							lessoncontent += (value2.student_email === user) ? '<a class="btn btn-mini remove-homework" data-id="'+ index2 +'"><i class="icon-remove"></i></a></p>' : '</p>';
							// display any reviews of a homework submission
							if (value2.reviews) {
								$.each(value2.reviews,function(index3, value3) {
									lessoncontent += '<p class="muted review">&nbsp;&nbsp;';
									//thumbs up or thumbs down
									lessoncontent += (value3.grade == 1) ?'<i class="icon-thumbs-up"></i>' : '<i class="icon-thumbs-down"></i>';
									lessoncontent += '&nbsp;&nbsp;'+value3.comment+'&nbsp;&mdash;&nbsp;'+value3.first_name+'';
									// is this review by the current logged in user
									lessoncontent += (value3.student_email === user) ? '&nbsp;<a class="btn btn-mini remove-review" data-id="'+ index3 +'"><i class="icon-remove"></i></a></p>' : '</p>';
								});
							} 
						});
					}
				});
			}		
			$("#lesson-info").html(lessoncontent);
			// set event to submit homework
			$(".submit-hw").click(function() {
				id = $(this).attr("data-exercise");
				$("#submit-exercise").attr("exercise-id",id);
				exercisecontent = "";
				switch (lesson.exercises[id].type) {
					case "url":
						exercisecontent += '<p class="span5">URL of page</p><p id="exercise-link" class="span5" contenteditable=true></p><p class="span5">Comment</p><p class="span5"><textarea columns=600 rows=2 class="span5" id="exercise-comment" name="exercise-comment"></textarea></p>';
						break;
					case "form":
						$.each(lesson.exercises[id].questions,function(index, question) {
							exercisecontent += '<p class="span5">'+question.text+'</p><p class="span5"><textarea columns=600 rows=2 class="span5" id="exercise-q'+index+'" name="exercise-q'+index+'" maxlength="400"></textarea></p>';
						});
						break;
					case "test":
						$.each(lesson.exercises[id].questions,function(index, question) {
							exercisecontent += '<p class="span5">'+question.text+'<br />';
							$.each(question.options,function(index2, option) {
								exercisecontent += '<input type="radio" name="exercise-q'+index+'" id="exercise-q'+index+'-o'+index2+'" value="'+index2+'" /><label for="exercise-q'+index+'-o'+index2+'">'+option+'</label>';
							});
							exercisecontent += '</p>';
						});
						break;
				}
				$("#exercise-content").html(exercisecontent);
				$("#submit-homework").modal("show");
			});
			// set event to view a homework submission
			$(".view-hw").click(function() {
				e_id = $(this).attr("data-exercise");
				h_id = $(this).attr("data-homework");
				homeworkcontent = "";
				switch (lesson.exercises[e_id].type) {
					case "url":
						//homeworkcontent += '<p class="span5">URL of page</p><p id="exercise-link" class="span5" contenteditable=true></p><p class="span5">Comment</p><p class="span5"><textarea columns=600 rows=2 class="span5" id="exercise-comment" name="exercise-comment"></textarea></p>';
						break;
					case "form":
						$.each(lesson.exercises[e_id].questions,function(index, value) {
							homeworkcontent += '<p class="span5"><strong>'+value.text+'</strong></p><blockquote class="span5">'+lesson.exercises[e_id].homeworks[h_id].answers[index].text+'</blockquote>';
						});
						break;
					case "test":
						$.each(lesson.exercises[e_id].questions,function(index, value) {
							homeworkcontent += '<p class="span5"><strong>'+value.text+'</strong></p>';
							homeworkcontent += '<dl class="span5 dl-horizontal"><dt>Answer Given:</dt><dd>'+value.options[lesson.exercises[e_id].homeworks[h_id].answers[index]]+'</dd></dl>';
						});
						break;
				}
				$("#homework-content").html(homeworkcontent);
				$("#view-homework").modal("show");
			});
			// set event to enter a review of a homework submission
			$(".thumbs").click(function() {
				$("#review-grade").removeClass("icon-thumbs-up").removeClass("icon-thumbs-down");
				if ($(this).hasClass("thumbsup")) {
					$("#review-grade").addClass("icon-thumbs-up");
				} else {
					$("#review-grade").addClass("icon-thumbs-down");
				}
				$("#review-subject").html($(this).attr("data-reviewee"));
				$("#submit-review").attr("homework-id",$(this).attr("data-homeworkid"));
				$("#write-review").modal("show");
			});	
			$(".remove-homework").click(function() {
				$("#delete-hw ").attr("homework-id",$(this).attr("data-id"));
				$("#update-homework").modal("show");
			});
			$("#delete-hw").unbind('click');
			$("#delete-hw").click(function() {
				var homeworkID = $(this).attr("homework-id");
				$("#update-homework").modal("hide");
				$.ajax({
					type: "POST",
					url: getRootPath()+"lesson-maker/remove-homework.php", 
					data: { homework: homeworkID }
				}).done(function(data) {
					alert("Your submission was deleted.");
					showLesson(lessonID);
					syllabus.students[user].homeworks[homeworkID] = {};
				});
			});
			$(".remove-review").click(function() {
				$("#delete-rev ").attr("data-id",$(this).attr("data-id"));
				$("#update-review").modal("show");
			});
			$("#delete-rev").unbind('click');
			$("#delete-rev").click(function() {
				var reviewID = $(this).attr("data-id");
				$.ajax({
					type: "POST",
					url: getRootPath()+"lesson-maker/remove-review.php", 
					data: { review: reviewID }
				}).done(function(data) {
					alert("Your review was deleted.");
					showLesson(lessonID);
				});
			});
		}); //close ajax done
	}
	
	$.ajax({
		type: "GET",
		url: getRootPath()+"xanthippe/syllabus.php",
		data: { syllabus_id: syllabus_id },
		datatype: "json"
	}).done(function( data) {
		data = $.parseJSON(data);
		syllabus = data[syllabus_id];
		console.log(syllabus);
		$("#course-info , title").html(syllabus.course_name+"&nbsp;"+syllabus.semester+"&nbsp;|&nbsp;"+syllabus.srjc_id+"&nbsp;|&nbsp; Section "+syllabus.section_number);
		var i = 1;
		$.each(syllabus.lessons, function(index, value) {
			$("#lesson-list").append("<tr class=lesson-listing data-index="+i+" data-id="+value.lesson_id+"><td>"+value.lesson_date.substr(0,value.lesson_date.indexOf(","))+"</td><td>"+value.topics+"</td></tr>");
			++i;
		});
		$(".lesson-listing").click(function() {
			currentLesson = $(this).attr("data-index");
			showLesson($(this).attr("data-id"));
			history.pushState({i: currentLesson}, 'Title', scriptPath + "/" + syllabusURI + (currentLesson == currentWeek ? '' : '/' + currentLesson));
			$(".lesson-listing").removeClass("info");
			$(this).addClass("info");
		});
		window.addEventListener("popstate", function(e) {
			currentLesson = history.state ? e.state.i : startLesson;
			showLesson($("table#lesson-list tbody tr").eq(currentLesson).attr("data-id"));
			$(".lesson-listing").removeClass("info");
			$("table#lesson-list tbody tr").eq(currentLesson).addClass("info");
		});
		if (syllabus.students) {
			$.each(syllabus.students, function(index, value) {
				if (value.type == "instructor") {
					$("#student-list").append('<p data-id='+value.email+' class="student-listing"><strong>'+value.first_name+'</strong></p>');
				} else {
					$("#student-list").append('<p data-id='+value.email+' class="student-listing">'+value.first_name+'</p>');
				}
			});
			$(".student-listing").click(function() {
				//sylla
				$("#studentname").text(syllabus.students[$(this).attr("data-id")].first_name);
				$("#studentavatar").attr("src","http://www.gravatar.com/avatar/"+syllabus.students[$(this).attr('data-id')].gravatar_hash);
				if (syllabus.students[$(this).attr("data-id")].github_userid) {
					var githublink = "<a href=http://www.github.com/"+syllabus.students[$(this).attr("data-id")].github_userid+"/"+syllabus.repository+">"+syllabus.students[$(this).attr("data-id")].github_userid+"</a>";
					$("#studentgithub").html(githublink);
				} else {
					$("#studentgithub").html("");  
				}
				if (syllabus.students[$(this).attr("data-id")].gallery_URL) {
					var gallerylink = '<a href="'+syllabus.students[$(this).attr("data-id")].gallery_URL+'">'+syllabus.students[$(this).attr("data-id")].gallery_URL+'</a>';
					$("#studentgalleryurl").html(gallerylink);
				} else {
					$("#studentgalleryurl").html("");  
				}
				if (syllabus.students[$(this).attr("data-id")].project_description) {
					
					$("#projectdesc").text(syllabus.students[$(this).attr("data-id")].project_description);
				} else {
					$("#projectdesc").html("");  
				}
				// display submissions in student page
				$("#homeworks").text("");
				if (syllabus.students[$(this).attr("data-id")].homeworks) {
					
					$.each(syllabus.students[$(this).attr("data-id")].homeworks, function(index, value) {
						if (value.topics) {
							$("#homeworks").append('<p><a href="'+value.url+'">'+value.topics+'</a>&mdash;'+value.comment+'</p>');
						}
					});
				}
				
				$("#viewprofile").modal('show');
			});
		};
		startLesson = currentLesson;
		$("table#lesson-list tbody tr").eq(currentLesson).addClass("info");
		$("table#lesson-list tbody tr").eq(currentWeek).addClass("warning");
		showLesson($("table#lesson-list tbody tr").eq(currentLesson).attr("data-id"));
		listProjects();
	});
	
	$("#general-info").hide();
	$("#general-info-hdr").click(function() {
		$("#general-info").slideToggle('slow');
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
				url: getRootPath()+"xanthippe/service/auth/index.php"
			}).done(function( data) {
				document.location.reload();
			});
		}
	});
	$('#studentid').text(user);
	getProfile(user);
	$("#update-profile").click(function() {
		if ($('#galleryurl').text() || $('#githubaccount').text() || $('#myproject').val()) {
			var profile = {email:user,syllabus_id:syllabus_id,gallery_URL:$('#galleryurl').text() , github_userid:$('#githubaccount').text() , project_description: $('#myproject').val()}
			$.ajax({
				type: "POST",
				url: getRootPath()+"lesson-maker/put-profile.php",
				data: { profile: profile },
				datatype: "json"
			}).done(function( data) {
				alert("Your Profile Was Updated");
				getProfile(user);
				syllabus.students[user].project_description = profile.project_description;
				syllabus.students[user].gallery_URL = profile.gallery_URL;
				syllabus.students[user].github_userid = profile.github_userid;
				$("#myprofile").modal('hide');
			});
		}
	});
	//   submit homework
	
	$("#submit-exercise").click(function() {
		var id = $("#submit-exercise").attr("exercise-id");
		var homework = {student_email:user,exercise_id:id};
		switch (lesson.exercises[id].type) {
			case "url":
				homework.exerciseLink = $("#exercise-link").text();
				homework.exerciseComment = $("#exercise-comment").val();
				break;
			case "form":
				var answers = new Array();
				$.each(lesson.exercises[id].questions,function(index, value) {
					answers[index] = $("#exercise-q"+index).val();
				});
				homework.formAnswers = JSON.stringify(answers);
				break;
			case "test":
				var answers = new Array();
				$.each(lesson.exercises[id].questions,function(index, value) {
					answers[index] = $("input[name=exercise-q"+index+"]:checked").val();
				});
				homework.testAnswers = JSON.stringify(answers);
				break;
		}
		$.ajax({
			type:"POST",
			url: getRootPath()+"lesson-maker/submit-homework.php",
			data: homework,
			datatype:"json"
		}).done(function(data) {
			alert("Your exercise was submitted");
			$("#submit-exercise").modal('hide');
			var data = $.parseJSON(data);
			//	   syllabus.lessons[data.lesson_id].exercises[data.exercise_exercise_id].homeworks[data.homework_id] = data;
			var newsubmission = {comment:data.comment, first_name:data.first_name, homework_id:data.homework_id, student_email:data.student_email, topics: syllabus.lessons[data.lesson_id].topics, url:data.URL};
			if (!syllabus.students[data.student_email].homeworks) {
				syllabus.students[data.student_email].homeworks = {};
			}
			// update the student record with the new submission
			syllabus.students[data.student_email].homeworks[data.homework_id] = newsubmission;
			showLesson(data.lesson_id);
		});
	});
	$("#submit-review").click(function() {
		var grade;
		if ($("#review-grade").hasClass("icon-thumbs-up")) {
			grade=1;
		} else {
			grade=0;
		}
		var review = {comment:$("#review-comment").val(), student_email: user , homework_id:$("#submit-review").attr("homework-id"), grade:grade};
		$.ajax({
			type:"POST",
			url: getRootPath()+"lesson-maker/put-review.php",
			data: review,
			datatype:"json"
		}).done(function(data) {
			alert("Your comment was entered");
			var data = $.parseJSON(data);
			$("#write-review").modal('hide');
			// syllabus.lessons[data.lesson_id].exercises[data.exercise_id].homeworks[data.homework_homework_id].reviews[data.review_id] = data;
			showLesson(data.lesson_id);
		});
	});
	$("body").swiperight(function() {
		if (currentLesson>1) {
			
			$("table#lesson-list tbody tr").eq(currentLesson).removeClass("info");
			currentLesson -= 1;
			$("table#lesson-list tbody tr").eq(currentLesson).addClass("info");
			
			showLesson($("table#lesson-list tbody tr").eq(currentLesson).attr("data-id"));
		}
		
	});
	$("body").swipeleft(function() {
		if (currentLesson < Object.keys(syllabus.lessons).length) {
			
			$("table#lesson-list tbody tr").eq(currentLesson).removeClass("info");
			currentLesson += 1;
			$("table#lesson-list tbody tr").eq(currentLesson).addClass("info");
			
			showLesson($("table#lesson-list tbody tr").eq(currentLesson).attr("data-id"));
		}
	});
});
