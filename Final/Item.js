
var Item = function(item_json) {
	this.item_id = item_json.item_id;
	this.m_name = item_json.m_name;
	this.c_name = item_json.c_name;
	this.year = item_json.year;
	this.logo = item_json.logo;
}

Item.prototype.makeItemDiv = function() {
	var item_div = $('<div></div>');
	item_div.addClass('result-row');
	item_div.attr('id', this.item_id);
	
	item_div.append($('<img>', {
		'class': 'logo',
		alt: this.m_name + "_logo",
		src: this.logo
	}));
	
	var text = $('<p>' + this.year + ' ' + this.m_name + ' ' + this.c_name + '</p>');
	item_div.append(text);
	
	item_div.append($('<img>', {
		'class': 'delete',
		alt: "delete",
		src: "images/cross.png"
	}));
	
	item_div.data('item', this);
	return item_div;
}