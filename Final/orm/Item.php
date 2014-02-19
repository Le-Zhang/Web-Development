<?php
date_default_timezone_set('America/New_York');

class Item
{
	private $item_id;
	private $m_name;
	private $c_name;
	private $year;
	private $logo;
	
	public static function create($item_id, $m_name, $c_name, $year, $logo) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "byao", "comp426final", "byaodb");
		
		$result = $mysqli->query("insert into Item values (" . $item_id .
								"', " . mysqli_escape_string($m_name) . "'" .
								"', " . mysqli_escape_string($c_name) . "'" .
								"', " . mysqli_escape_string($year) . "'" .
								"', " . mysqli_escape_string($logo) . "'");
		
		if($result) {
			return new Item($item_id, $m_name, $c_name, $year, $logo);
		}
		
		return null;
	}
	
	public static function createFromItem($item) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "byao", "comp426final", "byaodb");
				
		$result = $mysqli->query("INSERT INTO Item VALUES(" . $item->item_id .
				", '" . mysqli_escape_string($item->m_name) . "'" .
				", '" . mysqli_escape_string($item->c_name) . "'" .
				", " . mysqli_escape_string($item->year) . "" .
				", '" . mysqli_escape_string($item->logo) . "')");
		
		if($result) {
			return $item;
		}
		return null;
		
	}
	
	public static function findCars($make, $model, $year) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "byao", "comp426final", "byaodb");
		
		$result = $mysqli->query("SELECT * FROM Make, Car WHERE mid = make_id AND mname = '" . $make .
								 "' AND cname = '" . $model .
								 "' AND year = '" . $year . "'");
		if($result) {
			if($result->num_rows == 0) {
				return null;
			}
			
			$car_info = $result->fetch_array();
			
			if ($car_info['year'] != null) {
				$car_year = $car_info['year'];
			} else {
				$car_year = null;
			}
			
			return new Item(intval($car_info['cid']),
							$car_info['mname'],
							$car_info['cname'],
							$car_year,
							$car_info['logo']);	
		}
		return null;
		
	}
	
	private function __construct($item_id, $m_name, $c_name, $year, $logo) {
		$this->item_id = $item_id;
		$this->m_name = $m_name;
		$this->c_name = $c_name; 
		$this->year = $year;
		$this->logo = $logo;
	}
	
	public function getItemID() {
		return $this->id;
	}
	
	public function getMName() {
		return $this->m_name;
	}
	
	public function getCName() {
		return $this->c_name;
	}
	
	public function getYear() {
		return $this->year;
	}
	
	public function getLogo() {
		return $this->logo;
	}
	
	public function getJSON() {
		$json_obj = array('item_id' => $this->item_id,
						  'm_name' => $this->m_name,
				   		  'c_name' => $this->c_name,
				 		  'year' => $this->year,			
						  'logo' => $this->logo);
		return json_encode($json_obj);
	}
	
	public static function deleteById($id) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "byao", "comp426final", "byaodb");
		$result = $mysqli->query("DELETE FROM Item WHERE item_id = " . $id);
		
		if ($result) {
			// return mysql_affected_rows();
			return true;
		}
		return false;
		
	}
	
	public static function deleteAll() {
		$mysqli = new mysqli("classroom.cs.unc.edu", "byao", "comp426final", "byaodb");
		
		$result = $mysqli->query("DELETE FROM Item");
		
		if ($result) {
			// return mysql_affected_rows();
			return true;
		}
		return false;
		
	}
	
	public static function getAllItem() {
		$mysqli = new mysqli("classroom.cs.unc.edu", "byao", "comp426final", "byaodb");
		
		$result = $mysqli->query("SELECT * FROM Item");
		$item_array = array();
		
		if ($result) {
			while($next_row = $result->fetch_array()) {
				$item_id = intval($next_row['item_id']);
				$m_name = $next_row['m_name'];
				$c_name = $next_row['c_name'];
				$year = $next_row['year'];
				$logo = $next_row['logo'];
				
				$new_item = new Item(intval($next_row['item_id']),
									 $next_row['m_name'],
									 $next_row['c_name'],
									 $next_row['year'],
									 $next_row['logo']);
				
				if ($new_item instanceof Item) {
					array_push($item_array, $new_item->getJSON());
				}
			}

		}
		
		return $item_array;
	}
	
	
	
	
	
	
}
?>