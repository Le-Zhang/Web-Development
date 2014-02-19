<?php
date_default_timezone_set('America/New_York');

class Contact {
	
	private $fname;
	private $lname;
	private $address;
	private $city;
	private $state;
	private $zcode;
	private $pnumber;
	
	public static function create($fname, $lname, $address, $city, $state, $zcode, $pnumber) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "lezha", "lezhang426db", "lezhadb");
		
		$result = $mysqli->query("insert into Contact values (0, " .
								 "'" . $mysqli->real_escape_string($fname) . "', " .
								 "'" . $mysqli->real_escape_string($lname) . "', " .
								 "'" . $mysqli->real_escape_string($address) . "', " .
								 "'" . $mysqli->real_escape_string($city) . "', " .
								 "'" . $mysqli->real_escape_string($state) . "', " .
								 "'" . $mysqli->real_escape_string($zcode) . "', " .
								 "'" . $mysqli->real_escape_string($pnumber) . "') " );
		
		if ($result) {
			$id = $mysqli->insert_id;
			return new Contact($id, $fname, $lname, $address, $city, $state, $zcode, $pnumber);
		}
		return null;
	}
	
	public static function findByID ($id) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "lezha", "lezha426db", "lezhadb");
		
		$result = $mysqli->query("select * from Contact where id = " . $id);
		
		if ($result) {
			if ($result->num_rows == 0) {
				return null;
			}
			
			$contact_info = $result->fetch_array();
			
			return new Contact(intval($contact_info['id']), 
									  $contact_info['fname'],
									  $contact_info['lname'],
									  $contact_info['address'],
									  $contact_info['city'],
									  $contact_info['state'],
									  $contact_info['zcode'],
									  $contact_info['pnumber']);
		}
		return null;
	}
	
	private function __construct($id, $fname, $lname, $address, $city, $state, $zcode, $pnumber) {
		$this->id = $id;
		$this->fname = $fname;
		$this->lname = $lname;
		$this->address = $address;
		$this->city = $city;
		$this->state = $state;
		$this->zcode = $zcode;
		$this->pnumber = $pnumber;
	}
	
	public function getID() {
		return $this->id;
	}
	
	public function getFname() {
		return $this->fname;
	}
	
	public function getLname() {
		return $this->lname;
	}
	
	public function getAddress() {
		return $this->address;
	}
	
	public function getCity() {
		return $this->city;
	}
	
	public function getState() {
		return $this->state;
	}
	
	public function getZcode() {
		return $this->zcode;
	}
	
	public function getPnumber() {
		return $this->pnumber;
	}
	
	public function setFname($fname) {
		$this->fname = $fname;
		return $this->update();
	}
	
	public function setLname($lname) {
		$this->lname = $lname;
		return $this->update();
	}
	
	public function setAddress($address) {
		$this->address = $address;
		return $this->update();
	}
	
	public function setCity($city) {
		$this->city = $city;
		return $this->update();
	}
	
	public function setState($state) {
		$this->state = $state;
		return $this->update();
	}
	
	public function setZcode($zcode) {
		$this->zcode = $zcode;
		return $this->update();
	}
	
	public function setPnumber($pnumber) {
		$this->pnumber = $pnumber;
		return $this->update();
	}
	
	public function update () {
		$mysqli = new mysqli("classroom.cs.unc.edu", "lezha", "lezha426db", "lezhadb");
		
		$result = $mysqli->query("update Contact set " .
								 "fname=" . 
								 "'" . $mysqli->real_escape_string($this->fname) . "', " . 
								 "lname=" .
				                 "'" . $mysqli->real_escape_string($this->lname) . "', " .
							     "address=" .
								 "'" . $mysqli->real_escape_string($this->address) . "', " .
								 "city=" .
								 "'" . $mysqli->real_escape_string($this->city) . "', " . 
								 "state=" .
								 "'" . $mysqli->real_escape_string($this->state) . "', " . 
				       			 "zcode=" .
								 "'" . $mysqli->real_escape_string($this->zcode) . "', " . 
								 "pnumber=" .
								 "'" . $mysqli->real_escape_string($this->pnumber) . "', " .
								 " where id =" . $this->id);
		return $result;
	}

	public function delete() {
		$mysqli = new mysqli("classroom.cs.unc.edu", "lezha", "lezha426db", "lezhadb");
		$mysqli->query("delete from Contact where id = " . $this->id);
	}
	
	public function getJSON() {
		$json_obj = array('id' => $this->id,
						  'fname' => $this->fname,
						  'lname' => $this->lname,
						  'address' => $this->address,
						  'city' => $this->city,
						  'state' => $this->state,
						  'zcode' => $this->zcode,
						  'pnumber' => $this->pnumber);
		return json_encode($json_obj);
	}
	
	public static function getAllIDs() {
		$mysqli = new mysqli("classroom.cs.unc.edu", "lezha", "lezha426db", "lezhadb");
		
		$result = $mysqli->query("select id from Contact");
		$id_array = array();
		
		if ($result) {
			while ($next_row = $result->fetch_array()) {
				$id_array[] = intval($next_row['id']);
			}
		}
		return $id_array;
	}
	
	
	
	
	
	
	
	
	
	
}