$(document).ready(function() {
    alert("Your initialization code goes here!");
    
    var check = false;
    
    build_todo_list(TodoItem.all);
    
    $('#sort_by_title').click(function(e) {
    	console.log('sort_by_title()');
    	var new_arr = sort_items(TodoItem.all,'title');
    	$('#todolist-panel').empty();
    	build_todo_list(new_arr);
    	manu_details();
    });
    
    $('#sort_by_project').click(function () {
    	console.log('sort_by_project()');
    	var new_arr = sort_items(TodoItem.all, 'project');
    	$('#todolist-panel').empty();
    	build_todo_list(new_arr);
    	manu_details();
    });
    
    $('#sort_by_date').click(function () {
    	console.log('sort_by_priority()');
    	var new_arr = sort_items(TodoItem.all, 'due_date');
    	$('#todolist-panel').empty();
    	build_todo_list(new_arr);
    	manu_details();
    });
    
    $('#sort_by_priority').click(function () {
    	console.log('sort_by_priority()');
    	var new_arr = sort_items(TodoItem.all, 'priority');
    	$('#todolist-panel').empty();
    	build_todo_list(new_arr);
    	manu_details();
    });
    
    $('.show-incomplete').change(function () {
    	
    	check = !check;
    	console.log('show incomplete()' + check);
    	$('#todolist-panel').empty();
    	if(check) {
    		build_incomplete_todo_list(TodoItem.all);
    		manu_details();
    	} else {
    		build_todo_list(TodoItem.all);
    		manu_details();
    	}
    	
    	
    });
    
    manu_details();
    
    $('.ok-btn').click(function () {
    	var new_item = create_item();
    	appendToList(new_item);
    	$('#add-panel').addClass('hide');
    	$('#add-panel').hide();
    	manu_details();
    });
    
    $('#add-btn').click(function(){
    	$('#add-panel').removeClass('hide');
    	$('#add-panel').show();
    	manu_details();
    });
    
    
});

var build_todo_list = function(TodoList) {
	console.log("build_todo_list");
	
	var log_panel = $('#todolist-panel');
	var TodoItems = TodoList;
	
	
	for(var i=0; i<TodoItems.length; i++) {
		var next_todo = TodoItems[i];
		var new_log_entry = build_all_info(next_todo);
		log_panel.append(new_log_entry);
		 
	}
	
	log_panel.children().each(function (i,e) {
		e = $(e);
		if (i%2 == 1) {
			e.addClass('odd');
			e.removeClass('even');
		} else {
			e.addClass('even');
			e.removeClass('odd');
		}
	});	
	
};

var build_incomplete_todo_list = function (TodoList) {
	var log_panel = $('#todolist-panel');
	var TodoItems = TodoList;
	
	for(var i=0; i<TodoItems.length; i++) {
		var next_todo = TodoItems[i];
		
		if(!next_todo.complete) {
			var new_incomplete_log_entry = build_all_info(next_todo);
			log_panel.append(new_incomplete_log_entry);
	
		}
		
		
	}
	
	log_panel.children().each(function (i,e) {
		e = $(e);
		if (i%2 == 1) {
			e.addClass('odd');
			e.removeClass('even');
		} else {
			e.addClass('even');
			e.removeClass('odd');
		}
	});	
	
	
	
};

var sort_items = function(arr, prop) {
	console.log("inside the function, "+ prop);
	
	var new_arr = arr.sort(function (a, b) {
		console.log(a[prop] + ", " + b[prop]);
		
		if (a[prop] < b[prop]) {
			return -1;
		} else if (a[prop] > b[prop]) {
			return 1;
		} else {
			return 0;
		}
	});
	
	console.log(new_arr);
	return new_arr;
};

var show_hide_details = function (Id) {
	console.log('show_hide_details()');
	if ($('#' + Id + 'details').attr('class') == 'hide') {
    	
		$('#' + Id + 'details').hide().removeClass('hide');
		$('#' + Id + 'details').show('slow');
		$('#' + Id + 'details').addClass('details');
		$('#' + Id).addClass('open');
		
	} 

};

var build_detailed_info = function(item, complete) {
	var detailed_div = $('<div></div>');
	
	detailed_div.attr('id', item.id + 'details');
	detailed_div.addClass('hide');
	
	var detailed_list = $('<ul></ul>');
	
	
	detailed_list.append('<li><span>Project Name: </span>' + item.project 
			+ '</li><li><span>Due Date: </span>' + item.due_date
			+ '</li><li><span>Priority: </span>' + item.priority
			+ '</li><li><span>Complete Status: </span>' + complete + '</li><li><span>Note: </span>' + item.note
			+ '</li>');
	
	detailed_div.append(detailed_list);
	
	return detailed_div;
};

var build_all_info = function(next_todo) {
	console.log("build_all_info()" + next_todo.complete);
	var today = new Date();
	var new_log_entry = $('<div></div>');
	new_log_entry.attr('id', next_todo.id);
	new_log_entry.append('<div class="itemTitle"><span>' + next_todo.title +'</span></div>');
	//new_log_entry.append(next_todo.isComplete());
	
	var complete;
	if(next_todo.complete) {
		complete = 'Yes';
		console.log("It is Yes");
	} else {
		complete = 'No';
	}
	
	var detailed_div = $('<div></div>');
	
	detailed_div.attr('id', next_todo.id + 'details');
	detailed_div.addClass('hide');
	
	var detailed_list = $('<ul></ul>');
	
	
	detailed_list.append('<li><span>Project Name: </span>' + next_todo.project 
			+ '</li><li><span>Due Date: </span>' + next_todo.due_date
			+ '</li><li><span>Priority: </span>' + next_todo.priority
			+ '</li><li><span>Complete Status: </span>' + complete
			+ '</li><li><span>Note: </span>' + next_todo.note
			+ '</li>');
	
	//var edit_button = $('<button type="button" onclick="showEditPanel(' + "'" + next_todo.id + "'" + ')">Edit</button>');
	var edit_button = $('<button type="button">Edit</button>');
	edit_button.addClass('btn');
	edit_button.addClass('edit-btn');
	
	//var close_button = $('<button type="button" onclick="closeDetailPanel(' + "'" + next_todo.id + "'" + ')">Close</button>');
	var close_button = $('<button type="button">Close</button>');
	close_button.addClass('btn');
	close_button.addClass('close-btn');
	
	detailed_div.append(detailed_list);
	detailed_div.append(edit_button);
	detailed_div.append(close_button);
	
	$('.hide').hide();
	
	if (next_todo.complete) {
		new_log_entry.addClass('complete');
	}
	
	if(next_todo.due_date < today && next_todo.due_date !=  null) {
		new_log_entry.addClass('overdue');
	}

	new_log_entry.append(detailed_div);
	return new_log_entry;
};

var create_item = function () {
	var title = $('#add-panel input[name="title"]').val();
	var project = $('#add-panel input[name="project"]').val();
	var due_date = $('#add-panel input[name="due_date"]').val();
	var priority = $('#add-panel select[name="priority"]').val();
	var comp = $('#add-panel input:radio[name="complete"]:checked').val();
	var note = $('#add-panel input[name="note"]').val();
	
	var complete;
	if(comp == "true") {
		complete = true;
	} else {
		complete = false;
	}
	
	var new_item = new TodoItem(title, note, project, due_date, priority, complete);
	console.log('complete: ' + complete);
	
	return new_item;
};

var appendToList = function(new_item) {
	var log_panel = $('#todolist-panel');
	
	var new_item_div = build_all_info(new_item);
	
	if(TodoItem.all.length%2 == 1) {
		new_item_div.addClass('even');
		new_item_div.removeClass('odd');
	} else {
		new_item_div.addClass('odd');
		new_item_div.removeClass('even');
	}
	
	log_panel.append(new_item_div);
};


var manu_details = function() {
	
	var today = new Date();
    
    $('.itemTitle').click(function () {
    	console.log('show detailed information');
    	
    	var Id = $(this).parent().attr('id');
    	console.log($('#' + Id + 'details').attr('class'), Id);
    	
    	show_hide_details(Id);
        
    });
    
    
    $('#todolist-panel div button').click(function () {
    	console.log('edit detailed information');
    	var Id;
    	var item;
    	var TodoItems = TodoItem.all;
    	
    	
    	if(this.className == 'btn edit-btn') {
    		console.log(this.className);
    		Id = $(this).parent().parent().attr('id');
    		
    		console.log('showEditPanel(), id: ' + Id);
    		$('#'+Id + 'details').empty();
    		$('#'+Id + 'details').removeClass('details');
    		$('#'+Id + 'details').addClass('editable');
    		
    		for(var i=0; i<TodoItems.length; i++) {
    			if (TodoItems[i].id == Id) {
    				item = TodoItems[i];
    			} 
    		}
    		
    		var edit_panel = $('#'+Id + 'details');
    		
    		
    		var input_section = $('<ul></ul>');
    		input_section.attr('id', 'input');
    		input_section.append('<li><span>Title: </span><input type="text" name="title" value="'+ item.title +'"></li>'
    				+ '<li><span>Project Name: </span><input type="text" name="project" value="'+ item.project +'"></li>'
    				+ '<li><span>Due_Date: </span><input type="text" name="due_date" value="'+ item.due_date +'"></li>'
    				+ '<li><span>Priority: </span><select name="priority">'
    				+ '<option value="1">1</option>' 
    				+ '<option value="2">2</option>' 
    				+ '<option value="3">3</option>' 
    				+ '<option value="4">4</option>' 
    				+ '<option value="5">5</option>' 
    				+ '<option value="6">6</option>' 
    				+ '<option value="7">7</option>' 
    				+ '<option value="8">8</option>' 
    				+ '<option value="9">9</option>' 
    				+ '<option value="10">10</option>' 
    				+ '<select></li>'
    				+ '<li><span>Complete: </span><input type="radio" name="complete" value="true">Yes<input type="radio" name="complete" value="false">No</li>'
    				+ '<li><span>Note: </span><input type="text" name="note" value="'+ item.note +'"></li>');
    		
    		var save_button = $('<button type="button">Save</button>');
			save_button.addClass('btn');
			save_button.addClass('save-btn');
    		
    		edit_panel.append(input_section);
    		edit_panel.append(save_button);
    		
    		$('.save-btn').click(function() {
    			var complete;
    			
    			item.title = $('#input input[name="title"]').val();
    			item.project = $('#input input[name="project"]').val();
    			item.due_date = $('#input input[name="due_date"]').val();
    			item.priority = $('#input select[name="priority"]').val();
    			comp = $('#input input[type="radio"]:checked').val();
    			if(comp == "true") {
    				item.complete == true;
    				complete = "Yes";
    				$('#'+Id).addClass('complete');
    			} else {
    				item.complete == false;
    				complete = "No";
    				$('#'+Id).removeClass('complete');
    			}
    			item.note = $('#input input[name="note"]').val();
    			console.log("set title as: " + item.title + "project: " + item.project + "due_date: " + item.due_date + "priority: " + item.priority
    					+ "complete: " + item.complete + "note: " + item.note);
    			
    			
    			TodoItem[i] = item;
    			
    			$('#'+Id + 'details').empty();
        		$('#'+Id + 'details').removeClass('editable');
        		$('#'+Id + 'details').addClass('details');
    			
        		$('#'+Id+' div.itemTitle').empty();
        		$('#'+Id+' div.itemTitle').append('<span>' + item.title +'</span>');
        		
        		if(item.due_date < today && item.due_date !=  null) {
        			$('#'+Id).addClass('overdue');
        		} else {
        			$('#'+Id).removeClass('overdue');
        		}
        		
        		var detailed_list = $('<ul></ul>');
        		
        		detailed_list.append('<li><span>Project Name: </span>' + item.project 
        				+ '</li><li><span>Due Date: </span>' + item.due_date
        				+ '</li><li><span>Priority: </span>' + item.priority
        				+ '</li><li><span>Complete Status: </span>' + complete
        				+ '</li><li><span>Note: </span>' + item.note + '</li>');
        		
        		var edit_button = $('<button type="button">Edit</button>');
    			edit_button.addClass('btn');
    			edit_button.addClass('edit-btn');
    			
    			var close_button = $('<button type="button">Close</button>');
    			close_button.addClass('btn');
    			close_button.addClass('close-btn');
        		
        		edit_panel.append(detailed_list);
        		edit_panel.append(edit_button);
        		edit_panel.append(close_button);
        		
        		manu_details();
    		});
   		
    	} else if (this.className == 'btn close-btn') {
    		console.log(this.className);
    		
    		Id = $(this).parent().parent().attr('id');	    	
	    	$('#' + Id + 'details').removeClass('details');
	    	//$('#' + Id + 'details').hide();
	   		$('#' + Id + 'details').addClass('hide');
	   		$('.hide').hide();
	   		$('#' + Id).removeClass('open');
    		
	   		manu_details();
    	}
    
    });
    
    

};
