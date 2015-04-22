<?php
class Users{
	private $db;
	public function __construct(){
		$this->db = Connection::connect();
	}
	
	public function login($request){
		$success = false;
		
		//
		// Get credentials from request
		//
		$username = $request->username;
		$password = $request->password;
		
		//
		// Check database for user
		//
		$query = $this->db->prepare("SELECT UserID,password FROM User WHERE Username = ? LIMIT 1");
		if(!$query) throw new Exception($this->db->error);
		if(!$query->bind_param("s",$username)) throw new Exception($this->db->error);
		if(!$query->execute()) throw new Exception($this->db->error);
		if(!$query->store_result()) throw new Exception($this->db->error);
		
		if($query->num_rows == 1){
			if(!$query->bind_result($id,$hashedPassword)) throw new Exception($this->db->error);
			
			//
			// Check if the provided password matches the db password
			//
			$query->fetch();
			if(password_verify($password,$hashedPassword)){
				$_SESSION["id"] 	  = $id;
				$_SESSION["username"] = $username;
				$_SESSION["password"] = $password;
				$success = true;
			}
		}	
		
		return $success;	
	}
	
	public function requestAccount($request){
		$email = $request->email;
		$organization = $request->organization;
		$firstName = $request->firstName;
		$lastName = $request->lastName;
		
		mail($email, "Account Approved", "Dear " . $firstName . " " . $lastName . "\nWe have revieved your application and verified your association with this reputable organization.  Your account has been approved.  You can find your login details below which can be changed once your login.\n\nUsername:<username>\nPassword:<password>\n\nWe hope you find the service useful.\n\nSincerly,\nClimateView");
		
		return true;
	}
}