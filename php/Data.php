<?php
class Data{
	function getUserData($request){
		// automatically converted to json by Router
		return array();
	}
	
	function uploadUserData($request){
		$csvPath = $_FILES["dataUploadInput"]["tmp_name"];
		
		$csv = fopen($csvPath,"r");
		$a = fgetcsv($csv);
		fclose($csv);
		
		return $a;
	}
}