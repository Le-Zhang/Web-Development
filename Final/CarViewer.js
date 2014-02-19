var url_base = "http://wwwp.cs.unc.edu/Courses/comp426-f13/lezha/final/server-side";

$(document).ready(function() {
	
	$.ajax(url_base + "/car.php",
			{type: "GET",
			 dataType: "json",
			 data:{'load': true},
			 success: function (item_json_array, status, jqXHR) {
				 for (var i in item_json_array) {
					 var item = new Item(item_json_array[i]);
					 $('#result-panel').append(item.makeItemDiv());
				 }
			 },
			 error: function (jqXHR, status, error) {
				 alert(jqXHR.responseText);
			 }});
	
	$('#select-make').change(function() {
		var make = $('#select-make :selected').val();
		//var e = document.getElementById("select-make");
		//var make = e.options[e.selectedIndex].value;
		console.log(make);
		$('#select-model').empty();
		populateModel(make);
	});
	
	$('#select-model').change(function() {
		var model = $('#select-model :selected').val();
		console.log(model);
		$('#select-year').empty();
		populateYear(model);
	});
	
	$('#condition_form').on('submit',
							 function(e){
									e.preventDefault();
									console.log($(this).serialize());
									$.ajax(url_base + "/car.php",
											{type: "POST",
											 dataType: "json",
											 data: $(this).serialize(),
											 success: function(item_json, status, jqXHR){
												 var item = new Item(item_json);
												 // Item need a prototype method: makeItemDiv()
												 $('#result-panel').append(item.makeItemDiv());
											 },
											 error: function(jqXHR, status, error) {
												 alert(jqXHR.responseText);
											 }});
	});
	
	$('#get-btn').on('click',
					  function(e){
							e.preventDefault();
//							var id_array = new array();
//							$('div', '#result-panel').each(function(){
//								id_array.push($(this).attr('id'));
//								console.log("each id: " + $(this).attr('id'));
//							});
//							console.log("id_array: " + id_array);
							$.ajax(url_base + "/car.php",
									{type: "GET",
									 dataType: "json",
									 //data: {ids: id_array},
									 success: function(info_json_array, status, jqXHR) {
										 for(var i in info_json_array) {
											 var d_info = new detailedInfo(info_json_array[i]);
											 // javascript call to add detailed info to the info table....
											 d_info.makeComapreTable();
										 }
									 },
									 error: function(jqXHR, status, error) {
										 alert(jqXHR.responseText);
									 }});
							
	});
	
	$('#clear-btn').on('click',
						function (e) {
							e.preventDefault();
							if ($('#result-panel div').length == 0) {
								console.log("no item in the list");
								return;
							}
							$.ajax(url_base + "/car.php",
									{type: "GET",
									 dataType: 'json',
									 data: {'delete': true},
									 success: function(result, status, jqXHR) {
										 $('#result-panel').empty();
									 },
									 error: function(jqXHR, status, error) {
										 alert(jqXHR.responseText);
									 }});
	});
	
	$('.result-row img.delete').on('click',
									function(e) {
										e.preventDefault();
										var currentId = $(this).parent().attr('id');
										
										$.ajax(url_base + "/car.php",
												{type: "GET",
												 dataType: 'json',
												 data: {'delete': true,
													 	'id': currentId
													 	},
												 success: function(result, status, jqXHR){
												 	 console.log($(this).parent().attr('id'));
													 $(this).parent().remove();
												 },
												 error: function(jqXHR, status, error){
													 alert(jqXHR.responseText);
												 }});
	});
	
	
	
	
	
	
	
	function populateModel(make) {
		if (make == null || make == "") {
			alert("Please select make name");
		}
		
		if (make == "Audi") {
			$('#select-model').append('<option value="">select</option>');
			$('#select-model').append('<option value="A4">A4</option>');
			$('#select-model').append('<option value="A5">A5</option>');
			$('#select-model').append('<option value="A6">A6</option>');
		}
		
		if (make == "BMW") {
			$('#select-model').append('<option value="">select</option>');
			$('#select-model').append('<option value="328i">328i</option>');
			$('#select-model').append('<option value="335">335</option>');
			$('#select-model').append('<option value="530">530</option>');
		}
		
		if (make == "Mercedes") {
			$('#select-model').append('<option value="">select</option>');
			$('#select-model').append('<option value="C300">C330</option>');
			$('#select-model').append('<option value="C280">C280</option>');
		}
		
		if (make == "Infiniti") {
			$('#select-model').append('<option value="">select</option>');
			$('#select-model').append('<option value="G35">G35</option>');
		}
		
		if (make == "Honda") {
			$('#select-model').append('<option value="">select</option>');
			$('#select-model').append('<option value="Civic">Civic</option>');
			$('#select-model').append('<option value="Accord">Accord</option>');
		}
		
	}
	
	function populateYear(model) {
		if (model == null || model == "") {
			alert("Please select model name");
		}
		
		if(model == "A4") {
			$('#select-year').append('<option value="2009">2009</option>');
			$('#select-year').append('<option value="2010">2010</option>');
			$('#select-year').append('<option value="2010">2012</option>');
		}
		
		if(model == "A5") {
			$('#select-year').append('<option value="2013">2013</option>');
		}
		
		if(model == "A6") {
			$('#select-year').append('<option value="2013">2013</option>');
		}
		
		if(model == "328i") {
			$('#select-year').append('<option value="2013">2013</option>');
		}
		
		if(model == "335") {
			$('#select-year').append('<option value="2014">2014</option>');
		}
		
		if(model == "530") {
			$('#select-year').append('<option value="2014">2014</option>');
		}
		
		if(model == "C300") {
			$('#select-year').append('<option value="2014">2014</option>');
		}
		
		if(model == "C280") {
			$('#select-year').append('<option value="2014">2014</option>');
		}
		
		if(model == "Civic") {
			$('#select-year').append('<option value="2013">2013</option>');
		}
		
		if(model == "Accord") {
			$('#select-year').append('<option value="2013">2013</option>');
		}
		
		if(model == "G35") {
			$('#select-year').append('<option value="2013">2013</option>');
		}
		
		
	}
	
	
});