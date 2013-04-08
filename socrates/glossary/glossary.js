$(document).ready(function() {
	var getopenterms = function() {
		$.ajax({
	       type: "GET",
           url: "getopenterms.php",
           datatype: "json"
	    }).done(function(data) {
		   var openterms = $.parseJSON(data);
		   var content = '';
		   $.each(openterms, function(index, value) {			   
			   content += '<option>'+value.term+'</option>';			  
		   });
			$("#openterms").html(content);
	    });
	}
	getopenterms();
	$("#add-definition").click(function() {
		$.ajax({
			  type: "POST",
			  url: "../wiki/new-term.php", 
			  data: { term:$("#openterms").val(), definition: $("#enter-definition").val(), student_email:user }
			}).done(function(data) {
				alert("Your new definition was entered.");
				getopenterms();
			});
	});
});