<?php
class Users{
	public function login($request){
		$username = $request->username;
		$password = $request->password;
		
		// todo: authorize user and set session variables
		
		return true;	
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