<?php
class Data{
	function getUserData($request){
		// automatically converted to json by Router
		// $user_id = $_SESSION["id"]
		// $series = $request->series;
		
		$user_id = 0;
		$series = "temperature";
		
		$dataGenerator = new DataGenerator;
		return $dataGenerator->generateData($user_id, $series);
	}
	
	function uploadUserData($request){
		$csvPath = $_FILES["dataUploadInput"]["tmp_name"];
		
		$csv = fopen($csvPath,"r");
		$a = fgetcsv($csv);
		fclose($csv);
		
		return $a;
	}
}