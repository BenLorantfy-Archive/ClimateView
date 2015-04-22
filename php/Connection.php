<?php
class Connection{
	static public function connect(){
		$db = new mysqli('localhost', 'root', 'root', 'climateview');
		if($db->connect_errno > 0){
			throw new Exception("Connect failed: " . $db->connect_error);
		}
		return $db;
	}
}