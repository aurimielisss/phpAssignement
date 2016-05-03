<?php

/**
* @author Luca
 * definition of the User DAO (database access object)
 */
class UsersDAO {
	private $dbManager;
	function UsersDAO($DBMngr) {
		$this->dbManager = $DBMngr;
	}
	
	public function get($id = null) {
		$sql = "SELECT * ";
		$sql .= "FROM users ";
		if ($id != null)
					$sql .= "WHERE users.id=? ";
		$sql .= "ORDER BY users.id ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $id, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return $rows;
	}
	public function insert($parametersArray) {
		// 		insertion assumes that all the required parameters are defined and set
				$sql = "INSERT INTO users (username, password, created , isAdmin) ";
		$sql .= "VALUES (?,?,?,?) ";
		date_default_timezone_set("Europe/Dublin");
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $parametersArray ["username"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 2, $parametersArray ["password"], $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 3, date('Y/m/d H:i:s', time()), $this->dbManager->STRING_TYPE );
		$this->dbManager->bindValue ( $stmt, 4, $parametersArray["isAdmin"], $this->dbManager->BOOL_TYPE );
		
		$this->dbManager->executeQuery ( $stmt );
		
		return ($this->dbManager->getLastInsertedID ());
	}
	public function update($userID, $parametersArray) {
		$sql = "UPDATE users SET ";
		$sql .= "username = :username, ";
		$sql .= "password = :password ";
		
		if (!empty($parametersArray ["isAdmin"])) {
			$sql .= ", isAdmin = :isAdmin ";
			
		}
		$sql .= "WHERE users.id=:userId ";
					
		$stmt = $this->dbManager->prepareQuery ( $sql );
		
		$stmt->bindValue(":username", $parametersArray ["username"], $this->dbManager->STRING_TYPE);
		$stmt->bindValue(":password", $parametersArray ["password"], $this->dbManager->STRING_TYPE);
		$stmt->bindValue(":userId", $userID, $this->dbManager->INT_TYPE);
		$stmt->bindValue(":isAdmin", $parametersArray ["isAdmin"], $this->dbManager->BOOL_TYPE);
		
		$this->dbManager->executeQuery($stmt);
		
		return(true);
	}
	public function delete($userID) {
		$sql = "DELETE ";
		$sql .= "FROM users ";
		if ($userID != null)
					$sql .= "WHERE id= ? ";
		var_dump($sql);
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $userID, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		return true;
	}
	public function search($str) {
		//T		ODO
	}
}
?>
