<?php

require_once ('orm-contact.php');

$path_components = explode('/', $_SERVER['PATH_INFO']);

if ($_SERVER['REQUEST_METHOD'] == "GET") {
	//look up instance, index generation, deletion
	
	// /contact.php/<id>
	//if id is specified
	if ((count($path_components) >= 2) && ($path_components[1] != "")) {
			$contact_id = intval($path_components[1]);
			
			$contact = Contact::findByID($contact_id);
			
			if ($contact == null) {
				header("HTTP/1.0 404 Not Found");
				print("Contact id: " . $contact_id . " not found.");
				exit();
			}
			
			if (isset($_REQUEST['delete'])) {
				$contact->delete();
				header("Content-type: application/json");
				print(json_encode(true));
				exit();
			}
			
			header("Content-type: application/json");
			print($contact->getJSON());
			exit();
	}
	
	//if id is not specified
	header("Content-type:application/json");
	print(json_encode(Contact::getAllIDs()));
	exit();
	
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
	//creating or updating
	
	//if updating
	// /contact.php/<id>
	if ((count($path_components) >=2) && ($path_components[1] != "")) {
		
		$contact_id = intval($path_components[1]);
		$contact = Contact::findByID($contact_id);
		
		if ($contact == null) {
			header("HTTP/1.0 404 Not Found");
			print("Contact id: " . $contact_id . "not found while attempting update.");
			exit();
		}
		
		// validate the values
		$new_fname = false;
		if (isset($_REQUEST['fname'])) {
			$new_fname = trim($_REQUEST['fname']);
			if ($new_fname == "") {
				header("HTTP/1.0 400 Bad Request");
				print("Bad first name");
				exit();
			}
		}
		
		$new_lname = false;
		if (isset($_REQUEST['lname'])) {
			$new_lname = trim($_REQUEST['lname']);
			if ($new_lname == "") {
				header("HTTP/1.0 400 Bad Request");
				print("Bad last name");
				exit();
			}
		}
		
		$new_address = false;
		if (isset($_REQUEST['address'])) {
			$new_address = trim($_REQUEST['address']);
		}
		
		$new_city = false; 
		if (isset($_REQUEST['city'])) {
			$new_city = $_REQUEST['city'];
		}
		
		$new_state = false;
		if (isset($_REQUEST['state'])) {
			$new_state = $_REQUEST['state'];
		}
		
		$new_zcode = false;
		if (isset($_REQUEST['zcode'])) {
		 	$regex1 = "/^[0-9]{5}$/";
		 	$regex2 = "/^[0-9]{5}-[0-9]{4}$/";
		 	if((preg_match($regex1, $_REQUEST['zcode'])) || (preg_match($regex2, $_REQUEST['zcode']))){
		 		$new_zcode = $_REQUEST['zcode'];
		 	}
		}
		
		$new_pnumber = false;
		if (isset($_REQUEST['pnumber'])) {
			$regex1 = "[0-9]{3}-[0-9]{4}";
			$regex2 = "[0-9]{3}-[0-9]{3}-[0-9]{4}";
			if ((preg_match($regex1, $_REQUEST['pnumber'])) || (preg_match($regex2, $_REQUEST['pnumber']))) {
				$new_pnumber = $_REQUEST['pnumber'];
			}
		}
		
		//Update via ORM
		if ($new_fname) {
			$contact->setFname($new_fname);
		}
		if ($new_lname) {
			$contact->setLname($new_lname);
		}
		if ($new_address) {
			$contact->setAddress($new_address);
		}
		if ($new_city) {
			$contact->setCity($new_city);
		}
		if ($new_state) {
			$contact->setState($new_state);
		}
		if ($new_zcode) {
			$contact->setZcode($new_zcode);
		}
		if ($new_pnumber) {
			$contact->setPnumber($new_pnumber);
		}
		
		// Return JSON encoding of updated Contact
		header("Content-type:application/json");
		print($contact->getJSON());
		exit();
	} else { //else !(count($path_components) >= 2), following the /contact.php, (create new Contact)
		
		// Create a new Contact item
		
		// Validate values
		if (!isset($_REQUEST['fname'])) {
			header("HTTP/1.0 400 Bad Request");
			print("Missing first name");
			exit();
		}
		
		$fname = trim($_REQUEST['fname']);
		if ($fname == "") {
			header("HTTP/1.0 400 Bad Request");
			print("Bad first name");
			exit();
		}
		
		if (!isset($_REQUEST['lname'])) {
			header("HTTP/1.0 400 Bad Request");
			print("Missing last name");
			exit();
		}
		
		$lname = trim($_REQUEST['lname']);
		if ($lname == "") {
			header("HTTP/1.0 400 Bad Request");
			print("Bad last name");
			exit();
		}
		
		$address = "";
		if (isset($_REQUEST['address'])) {
			$address = trim($_REQUEST['address']);
		}
		
		$city = "";
		if (isset($_REQUEST['city'])) {
			$city = trim($_REQUEST['city']);
		}
		
		$state = "";
		if (isset($_REQUEST['state'])) {
			$state = trim($_REQUEST['state']);
		}
		
		$zcode = "";
		if (isset($_REQUEST['zcode'])) {
			$regex1 = "/^[0-9]{5}$/";
			$regex2 = "/^[0-9]{5}-[0-9]{4}$/";
			if(!(preg_match($regex1, $_REQUEST['zcode'])) && !(preg_match($regex2, $_REQUEST['zcode']))){
				header("HTTP/1.0 400 Bad Request");
				print("Bad zip code, should follow XXXXX or XXXXX-XXXX");
				exit();
			}
			$zcode = trim($_REQUEST['zcode']);
		}
		
		$pnumber = "";
		if (isset($_REQUEST['pnumber'])) {
			$regex1 = "/^[0-9]{3}-[0-9]{4}$/";
			$regex2 = "/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/";
			if (!(preg_match($regex1, $_REQUEST['pnumber'])) && !(preg_match($regex2, $_REQUEST['pnumber']))) {
				header("HTTP/1.0 400 Bad Request");
				print("Bad phone number, should follow XXX-XXXX or XXX-XXX-XXXX");
				exit();
			}
			$pnumber = trim($_REQUEST['pnumber']);
		}
		
		// Create new Contact via ORM
		$new_contact = Contact::create($fname, $lname, $address, $city, $state, $zcode, $pnumber);
		
		//Report if failed
		if ($new_contact == null) {
			header("HTTP/1.0 500 Server Error");
			print("Server couldn't create new contact.");
			exit();
		}
		
		// Generate JSON encoding of new Contact
		header("Content-type: application/json");
		print($new_contact->getJSON());
		exit();
	}
}

//if _SERVER['REQUEST_METHOD'] != GET/POST 

header("HTTP/1.0 400 Bad Request");
print("Did not understand URL");

?>
