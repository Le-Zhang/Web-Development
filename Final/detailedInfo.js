
var detailedInfo = function(detailedinfo_json){
	this.id = detailedinfo_json.id;
	this.name = detailedinfo_jason.name;
	this.c_pic = detailedinfo_json.c_pic;
	this.year = detailedinfo_json.year;
	this.msrp = detailedinfo_json.msrp;
	this.invoice = detailedinfo_json.invoice;
	this.fuel_capacity = detailedinfo_json.fuel_capacity;
	this.fuel_type = detailedinfo_json.fuel_type;
	this.horsepower = detailedinfo_json.horsepower;
	this.torque = detailedinfo_json.torque;
	this.fuel_economy = detailedinfo_json.fuel_economy;
	this.engine_displacement = detailedinfo_json.engine_displacement;
	this.make = detailedinfo_json.make;
	this.type = detailedinfo_json.type;
	this.speed = detailedinfo_json.speed;
}


detailedInfo.prototype.makeCompareTable = function(){
	
	//create th for header row of table, with cross image, car name, and car picture
	var headerdiv = '';
		headerdiv += '<th><br>';
		headerdiv += '<img class="delete" src="images/cross.png" alt="delete"><br>';
		headerdiv += '<p>'+ this.year + ' ' + this.make + ' ' + this.name + ' ' + this.engine_displacement + '</p><br>';
		headerdiv += '<img class="compare-pic" alt="' + this.name +'" src = "' + this.c_pic + '"><br>';
		headerdiv += '</th>';
	
	//append header cell of each car to header tr	
	$("#header-row").append(headerdiv);
	
	//create and append msrp td to msrp row
	var msrpdiv = '';
		msrpdiv += '<td> $'+ this.msrp + '</td>';
	
	$("#msrp").append(msrpdiv);
	
	//create and append invoice to invoice row
	var invoicediv = '';
		invoicediv += '<td> $' + this.invoice + '</td>';
		
	$("#invoice").append(invoicediv);
	
	//create and append fuel type to fuel type row
	var fuelTypediv = '';
		fuelTypediv += '<td>' + this.fuel_type + '</td>';
	$("#fuel_type").append(fuelTypediv);
	
	//create and append engine displacement to engine displace row
	var engineDisplacementdiv = '';
		engineDisplacementdiv = '<td>' + this.engine_displacement + '</td>';
	$('#engine_displacement').append(engineDisplacementdiv);
	
	//create and append horsepower to horsepower row
	var horsepowerdiv = '';
		horsepowerdiv = '<td>' + this.horsepower + '</td>';
	$('#horsepower').append(horsepowerdiv);
	
	//create and append torque to torque row
	var torquediv = '';
		torquediv = '<td>' + this.torque + '</td>';
	$('#torque').append(torquediv);
	
	//create and append mpg to mpg row
	var mpgdiv = '';
		mpgdiv = '<td>' + this.fuel_economy + '</td>';
	$('#mpg').append(mpgdiv);
	
	//create and append fuel capacity to fuel_capacity row
	var fuelCapacitydiv = '';
		fuelCapacitydiv = '<td>' + this.fuel_capacity + '</td>';
	$('#fuel_capacity').append(fuelCapacitydiv);
	
	//create and append transmission to transimission table
	var transmissiondiv = '';
		transmissiondiv = '<td>' + this.speed +' Speed' + this.type + '</td>';
	$('#transmission').find('tr').append(transmissiondiv);
	
}


