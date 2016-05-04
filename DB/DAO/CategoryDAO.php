<?php

class CategoryDAO {
    private $dbManager;
    function CategoryDAO($dbManager){
        $this->dbManager = $dbManager;
    }
    
    public function get($id = null) {
		$sql = "SELECT * ";
		$sql .= "FROM category ";
		if ($id != null)
					$sql .= "WHERE category.id=? ";
		$sql .= "ORDER BY category.id ";
		
		$stmt = $this->dbManager->prepareQuery ( $sql );
		$this->dbManager->bindValue ( $stmt, 1, $id, $this->dbManager->INT_TYPE );
		$this->dbManager->executeQuery ( $stmt );
		$rows = $this->dbManager->fetchResults ( $stmt );
		
		return $rows;
	}
    
}