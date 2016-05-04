<?php
require_once "DB/pdoDbManager.php";
require_once "DB/DAO/CategoryDAO.php";

class CategoryModel {
    private $categoryDAO;
    private $dbManager;
    public $apiResponse;
    
    public function __construct(){
        $this->dbManager = new pdoDbManager();
        $this->categoryDAO = new CategoryDAO($this->dbManager);
        $this->dbManager->openConnection();
    }
    
    public function get(){
        return $this->categoryDAO->get();
    }
}