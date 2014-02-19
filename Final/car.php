<?php

require_once('orm/Item.php');
require_once('orm/DInfo.php');

$path_components = explode("/", $_SERVER['PATH_INFO']);

if ($_SERVER['REQUEST_METHOD'] == "GET") {
	
	
	// Check to see if deleting
	if (isset($_REQUEST['delete'])) {
		
		$deleted = false;
		// Delete one item from list
		if (isset($_REQUEST['id'])) {
			$deleted = Item::deleteById($_REQUEST['id']);
		}
		
		// Else, clear the item list (delete all items from the list)
		$deleted = Item::deleteAll();
		
		if($deleted) {
			header("Content-type: application/json");
			//??????
			print (json_encode($deleted));
			exit();
		} else {
			header("HTTP/1.0 500 Server Error");
			print("Server couldn't delete item");
			exit();
		}
		
	} else if(isset($_REQUEST['load'])) {
		// Check to see if loading items into item list
		
		$item_array = array();
		
		$item_array = Item::getAllItem();
		header("Content-type: application/json");
		print(json_encode($item_array));
		exit();
		
	} else {
		// To get detailed information, following matches /car.php
		
		// Validate values of item_id array
// 		if (!isset($_REQUEST['ids'])) {
// 			header("HTTP/1.0 400 Bad Request");
// 			print("Missing ids of item");
// 			exit();
// 		}
		
//		$ids_array = array();
// 		if (sizeof($_REQUEST['ids']) == 0) {
// 			header("HTTP/1.0 400 Bad Request");
// 			print("No item_id is passed in");
// 			exit();
// 		}
//		$ids_array = $_REQUEST['ids'];
		
//		$detail_info_array = DInfo::getAllInfo($id_array);

		$detail_info_array = array();
		
		$detail_info_array = DInfo::getAllInfo();
		
		if ($detail_info_array == null || sizeof($detail_info_array) == 0) {
			header("HTTP/1.0 400 Bad Request");
			print("Cannot get detailed information");
			exit();
		}
		
		// If get detailed information of provided ids
		header("Content-type: application/json");
		//?????
		print(json_encode($detail_info_array));  
		exit();
		
	}
	
	
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
	// To create an Item object, following matches /car.php
	
	// Validate values
	if (!isset($_REQUEST['m_name'])) {
		header("HTTP/1.0 400 Bad Request");
		print("Missing Make Name");
		exit();
	}
	
	if (!isset($_REQUEST['c_name'])) {
		header("HTTP/1.0 400 Bad Request");
		print("Missing Model Name");
		exit();
	}
	
	if (!isset($_REQUEST['year'])) {
		header("HTTP/1.0 400 Bad Request");
		print("Missing Year");
		exit();
	}
	
	$m_name = $_REQUEST['m_name'];
	$c_name = $_REQUEST['c_name'];
	$year = $_REQUEST['year'];
	
	// Find the car and create item via ORM
	$new_item = Item::findCars($m_name, $c_name, $year);
	
	// Insert the item into table via ORM
	$new_item = Item::createFromItem($new_item);
	
	
	// Report if failed
	if($new_item == null) {
		header("HTTP/1.0 500 Server Error");
		print("Server couldn't create new item");
		exit();
	}
	
	// Generate JSON encoding of new Item
	header("Content-type: application/json");
	print($new_item->getJSON);
	exit();
	
} 

header("HTTP/1.0 400 Bad Request");
print("Did not understand URL");

?>
