var Contact = function(contact_json) {
	this.id = contact_json.id;
	this.fname = contact_json.fname;
	this.lname = contact_json.lname;
	this.address = contact_json.address;
	this.city = contact_json.city;
	this.state = contact_json.state;
	this.zcode = contact_json.zcode;
	this.pnumber = contact_json.pnumber;
	this.name = this.fname + this.lname;
}

Contact.prototype.makeCompactDiv = function () {
	var cdiv = $("<div></div>");
	
	var name_div = $("<div></div>")
	name_div.html(this.name);
	cdiv.append(name_div);
	
	cdiv.data('contact', this);
	return cdiv;
	
}