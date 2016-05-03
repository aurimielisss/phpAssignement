<?php
require_once "DB/pdoDbManager.php";
require_once "DB/DAO/UsersDAO.php";
require_once "Validation.php";
class UserModel {
	private $UsersDAO; // list of DAOs used by this model
	private $dbmanager; // dbmanager
	public $apiResponse; // api response
	private $validationSuite; // contains functions for validating inputs
	public function __construct() {
		$this->dbmanager = new pdoDbManager ();
		$this->UsersDAO = new UsersDAO ( $this->dbmanager );
		$this->dbmanager->openConnection ();
		$this->validationSuite = new Validation ();
	}
	public function getUsers() {
		return  ($this->UsersDAO->get ());
	}
	public function getUser($userID) {
		if (is_numeric ( $userID ))
			return ($this->UsersDAO->get ( $userID ));
		
		return false;
	}
	
	public function createNewUser($newUser) {
		// validation of the values of the new user
		
		// compulsory values
		if (! empty ( $newUser ["username"] ) && ! empty ( $newUser ["password"] ) ) {
						
			if (($this->validationSuite->isLengthStringValid ( $newUser ["username"], TABLE_USER_USERNAME_LENGTH )) 				 
				&& ($this->validationSuite->isLengthStringValid ( $newUser ["password"], TABLE_USER_PASSWORD_LENGTH ))) {
					$newUser["password"] = password_hash($newUser["password"],PASSWORD_DEFAULT);
				
				if (empty($newUser["isAdmin"])) {
					$newUser["isAdmin"] = false;
				}
				
				if ($newId = $this->UsersDAO->insert ( $newUser ))
					return ($newId);
			}
		}
		
		return (false);
	}
	public function updateUser($userID, $userNewRepresentation) {
		if (!empty($userID)) {
			
			// if ($userNewRepresentation["isAdmin"] != null) {
			// 	$userNewRepresentation["isAdmin"] = 1;
			// }else {
			// 	$userNewRepresentation["isAdmin"] = 0;
			// }
			
			return ($this->UsersDAO->update ($userID, $userNewRepresentation));
					
			
		}
		return false;
	}
	public function searchUsers($string) {
		
		
		
	}
	public function deleteUser($userID) {
		if (is_numeric ( $userID ))
			return ($this->UsersDAO->delete ( $userID ));
		
		return false;
	}
	public function __destruct() {
		$this->UsersDAO = null;
		$this->dbmanager->closeConnection ();
	}
}
?>