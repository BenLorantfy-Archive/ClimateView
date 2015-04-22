<?php
class DataGenerator{
	private $db;

	public function __construct()
	{
		$this->db = new \mysqli('localhost', 'root', 'Jratva-online1', 'climateview');
		if($this->db->connect_errno > 0){
			throw new Exception("Connect failed: " . $db->connect_error);
		}
	}	
		
	public function generateData($user_id, $series){
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
}

$js = new DataGenerator();
echo $js->generateData(0,"precipitation");
?>