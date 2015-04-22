<?php
class Data{
	private $db;

	public function __construct()
	{
		$this->db = Connection::connect();
	}	
		
	private function generateData($user_id, $series){
		$sql = 'SELECT statecode, yearmonth,';	
		switch($series)
		{
			case "precipitation":
				$sql .= 'PCP';
				break;
			case "days":
				$sql .= 'CDD,HDD';
				break;
			case "temperature":
				$sql .= 'TMIN,TMAX,TAVG';
				break;
		}
		$sql .= ' FROM user' . $user_id . 'data';
		
		$query = $this->db->prepare($sql);
		
		if(!$query) throw new Exception($this->db->error);
		if(!$query->execute()) throw new Exception($this->db->error);
		if(!$query->store_result()) throw new Exception($this->db->error);

		$data = array();
		if($query->num_rows >= 1){
			switch($series)
			{
				case "precipitation":
					if($query->bind_result($stateCode, $yearMonth, $PCP)){
					$success = true;
						while($query->fetch()){
							array_push($data, array(
								 "STATECODE" => $stateCode
								,"YEARMONTH" => $yearMonth
								,"PCP" => $PCP
							));
						}								
					}
					break;
				case "days":
					if($query->bind_result($stateCode, $yearMonth, $CDD, $HDD)){
					$success = true;
						while($query->fetch()){
							array_push($data, array(
								 "STATECODE" => $stateCode
								,"YEARMONTH" => $yearMonth
								,"CDD" => $CDD
								,"HDD" => $HDD
							));
						}								
					}				
					break;
				case "temperature":
					if($query->bind_result($stateCode, $yearMonth, $TMIN, $TMAX, $TAVG)){
					$success = true;
						while($query->fetch()){
							array_push($data, array(
								 "STATECODE" => $stateCode
								,"YEARMONTH" => $yearMonth
								,"TMIN" => $TMIN
								,"TMAX" => $TMAX
								,"TAVG" => $TAVG
							));
						}								
					}				

					break;
			}
		}
	
		return $data;
	}
	
	function getUserData($request){
		// automatically converted to json by Router
		$user_id = $_SESSION["id"];
		// $series = $request->series;
		
		$series = "temperature";
		
		return $this->generateData($user_id, $series);
	}
	
	private function createTable($tblName){
		$query = $this->db->prepare("CALL createUserTable(?)");
		if(!$query) throw new Exception("prepare:" . $this->db->error);
		if(!$query->bind_param("s",$tblName)) throw new Exception("bind:" . $this->db->error);
		if(!$query->execute()) throw new Exception("execute:" . $this->db->error);
		if(!$query->store_result()) throw new Exception("store:" . $this->db->error);		
	}
	
	public function uploadUserData($request){
		$valid = true;
		
		//
		// Get path of uploaded file
		// This path is only temporary, but since we're not storing the actual csv file, we don't have to worry about
		//
		$csvPath = $_FILES["dataUploadInput"]["tmp_name"];
		
		//
		// Create unique user table
		//
		$tblName = "User" . $_SESSION["id"] . "Data";
		
		//
		// Create user table
		//
		$this->createTable($tblName);
		
		//
		// Open csv file
		// 
		$csv = fopen($csvPath,"r");
		
		//
		// Iterate over each line in csv file
		//
		while($row = fgetcsv($csv)){
			// Skip row if table header
			if(!ctype_alpha($row[0])){
			
				//
				// Extract required information from csv
				//
				$stateCode = trim($row[0]);
				$yearMonth = trim($row[2]);
				$pcp = trim($row[3]);
				$cdd = trim($row[9]);
				$hdd = trim($row[10]);
				$tmin = trim($row[18]);
				$tmax = trim($row[19]);
				$tavg = trim($row[4]);
				
				$query = $this->db->prepare("CALL transformProc(?,?,?,?,?,?,?,?,?)");
				if(!$query) throw new Exception("prepare:" . $this->db->error);
				if(!$query->bind_param("siidddddd",$tblName,$stateCode,$yearMonth,$pcp,$cdd,$hdd,$tmin,$tmax,$tavg)) throw new Exception("bind:" . $this->db->error);
				if(!$query->execute()) throw new Exception("execute:" . $this->db->error);
				if(!$query->store_result()) throw new Exception("store:" . $this->db->error);
			}
		}
		
		return $valid;
	}
}