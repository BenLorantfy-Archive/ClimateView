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
		}else{
			throw new Exception($this->db->error);
		}
	
		return $data;
	}
	
	function getUserData($request){
		// automatically converted to json by Router
		// $user_id = $_SESSION["id"]
		// $series = $request->series;
		
		$user_id = 0;
		$series = "temperature";
		
		return $this->generateData($user_id, $series);
	}
	
	function uploadUserData($request){
		$csvPath = $_FILES["dataUploadInput"]["tmp_name"];
		
		$csv = fopen($csvPath,"r");
		$a = fgetcsv($csv);
		fclose($csv);
		
		return $a;
	}
}