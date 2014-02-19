var url_base = "http://www.cs.unc.edu/Courses/comp426-f13/lezha/a6/server-side"

$(document).ready(function () {
	//1. need to use php to load contact item
	
	$('#new_contact_form').on('submit',
							   function (e) {
									e.preventDefault();
									$.ajax(url_base + "/contact.php",
										   {type: "POST",
												  dataType: "json",
												  data: $(this).serialize(),
												  success: function(contact_json, status, jqXHR) {
													  var c = new Contact(contact_json);
													  $('#contact_list').append(c.makeCompactDiv());
											      },
											   	  error: function(jqXHR, status, error) {
											   		  alert(jqXHR.responseText);
											   	  }});
	});
	
	var load_contact_item = function (id) {
		$.ajax(url_base + "/contact.php/" + id,
				{type: "GET",
				 dataType: "json",
				 success: function(contact_json, status, jqXHR) {
					 var c = new Contact(contact_json);
					 $('#contact_list').append(c.makeCompactDiv());
				 }
				});
	}
	
	
});