<?php
date_default_timezone_set("America/New_York");

class DInfo
{
	private $cid;
	private $m_name;
	private $c_name;
	private $year;
	private $msrp;
	private $invoice;
	private $fuel_capacity;
	private $fuel_type;
	private $horsepower;
	private $torque;
	private $fuel_economy;
	private $speed;
	private $type;
	private $c_pic;
	
	public function getCid(){
		return $this->cid;
	}
	private function __construct($cid, $m_name, $c_name, $year, $msrp, $invoice, $fuel_capacity, $fuel_type, $horsepower, $torque, $fuel_economy, $speed, $type, $c_pic) {
		$this->cid = $cid;
		$this->m_name = $m_name;
		$this->c_name = $c_name;
		$this->year = $year;
		$this->msrp = $msrp;
		$this->invoice = $invoice;
		$this->fuel_capacity = $fuel_capacity;
		$this->fuel_type = $fuel_type;
		$this->horsepower = $horsepower;
		$this->torque = $torque;
		$this->fuel_economy = $fuel_economy;
		$this->speed = $speed;
		$this->type = $type;
		$this->c_pic = $c_pic;
	}
	
	public static function findById($id) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "byao", "comp426final", "byaodb");
		// sql: SELECT * FROM Make, Car, Engine, Transmission WHERE mid = make_id AND Car.engine_id = Engine.engine_id AND 
		// Car.transmission_id = Transmission.transmission_id AND cid = $id;
		$result = $mysqli->query("SELECT * FROM Make, Car, Engine, Transmission WHERE mid = make_id AND Car.engine_id = Engine.engine_id 
									AND Car.transmission_id = Transmission.transmission_id AND cid = " . $id);
		
		if ($result) {
			if ($result->num_rows == 0) {
				return null;
			}
			
			$dinfo_info = $result->fetch_array();
			
			if ($dinfo_info['year'] != null) {
				$year = new DateTime($dinfo_info['year']);
			} else {
				$year = null;
			}
			
			return new DInfo(intval($dinfo_info['cid']), 
									$dinfo_info['mname'], 
									$dinfo_info['cname'], 
									$year, 
									$dinfo_info['msrp'], 
									$dinfo_info['invoice'], 
									$dinfo_info['fuel_capacity'], 
									$dinfo_info['fuel_type'], 
									$dinfo_info['horsepower'], 
									$dinfo_info['torque'], 
									$dinfo_info['fuel_economy'], 
									$dinfo_info['speed'], 
									$dinfo_info['type'], 
									$dinfo_info['c_pic']);
		}
		return null;
	}
	
	public static function getAllInfo() {
		
		$id_array = array();
		$detail_info_array = array();
		
		$mysqli = new mysqli("classroom.cs.unc.edu", "byao", "comp426final", "byaodb");
		
		$result = $mysqli->query("SELECT item_id FROM Item");
		
		if ($result) {
			while ($next_row = $result->fetch_array()) {
				$id_array[] = intval($next_row['item_id']);
			}
		}
		
		if (sizeof($id_array) == 0) {
			return null;
		}
		
		// Iterate the id_array and get each DInfo (JSON encoded) by id
		foreach ($id_array as $id) {	
			$detail_info = DInfo::findById($id);
			if($detail_info instanceof DInfo)
 		// 		print($detail_info->getJSON());		
			array_push($detail_info_array, $detail_info->getJSON());
		}
		
		if (sizeof($detail_info_array != 0)) {
			return $detail_info_array;
		}
		
		return null;
		
	}
	
	public function getJSON() {	
		$json_obj = array('cid' => $this->cid,
						  'm_name' => $this->m_name,
						  'c_name' => $this->c_name,
						  'year' => $this->year,
						  'msrp' => $this->msrp,
						  'invoice' => $this->invoice,
						  'fuel_capacity' => $this->fuel_capacity,
						  'fuel_type' => $this->fuel_type,
						  'horsepower' => $this->horsepower,
						  'torque' => $this->torque,
						  'fuel_economy' => $this->fuel_economy,
						  'speed' => $this->speed,
						  'type' => $this->type,
						  'c_pic' => $this->c_pic);
		return json_encode($json_obj);
	}
	
	
	
	
	
	
	
	
	
	
}


?>