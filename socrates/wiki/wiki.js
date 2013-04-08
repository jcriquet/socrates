$(document).ready(function() {
	$("#update-definition").modal("hide");
	var getwiki = function() {
		$.ajax({
	       type: "GET",
           url: "getwiki.php",
           datatype: "json"
	    }).done(function(data) {
		   var terms = $.parseJSON(data);
		   var content = '<dl">';
		   $.each(terms, function(index, value) {			   
			   content += '<dt>'+value.term+'</dt>';
			   if (value.definition) {
	               $.each(value.definition,function(index2,value2) {
					   if (value2.email === user) {
			         		content += '<dd>'+value2.definition+'&mdash;<small>'+value2.first_name+'</small>&nbsp;<a class="btn btn-mini remove-definition" data-term="'+ value2.term_term +'" data-id="'+value2.definition_id+'"><i class="icon-remove"></i></a></dd>';
					   } else {
						   content += '<dd>'+value2.definition+'&mdash;<small>'+value2.first_name+'</small></dd>';
					   }
			       });
			   };
		   });
		    content += '</dl>';
			$("#glossary").html(content);
			$("a.remove-definition").click(function() {
				$("#change-term").html($(this).attr("data-term"));
				$("#new-definition").val(terms[$(this).attr("data-term")].definition[$(this).attr("data-id")].definition);
				$("#delete-definition , #change-definition").attr("data-id",$(this).attr("data-id"));
				$("#update-definition").modal("show");
			});
			$('#change-definition , #delete-definition').unbind('click');
			$("#change-definition").click(function() {
				var definitionID = $(this).attr("data-id");
				var newDefinition = $("#new-definition").val();
				$.ajax({
					  type: "POST",
					  url: "update-definition.php", 
					  data: { definition: definitionID , update:newDefinition }
					}).done(function(data) {
						alert("Your definition was updated.");
						getwiki();
					});
				
			});
			$("#delete-definition").click(function() {
				var definitionID = $(this).attr("data-id");
				$.ajax({
					  type: "POST",
					  url: "remove-definition.php", 
					  data: { definition: definitionID }
					}).done(function(data) {
						alert("Your definition was deleted.");
						getwiki();
					});
	        });
	    });
	
	}
	getwiki();
	$("#submit-definition").click(function() {
		$.ajax({
			  type: "POST",
			  url: "new-term.php", 
			  data: { term:$("#enter-term").text(), definition: $("#enter-definition").val(), student_email:user }
			}).done(function(data) {
				alert("Your new definition was entered.");
				getwiki();
			});
	});
	$.ajax({
		type: "GET",
        url: "get-links.php",
        datatype: "json"
	}).done(function(data) {
		 var links = $.parseJSON(data); 
		 var linkcontent = "";
		 $.each(links, function(index, value) {
			linkcontent += '<p><a href="'+value.url+'">'+value.title+'</a></p>';
		 });
		 $("#references").html(linkcontent);
	});
});