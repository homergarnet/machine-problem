<?php

class Database{
    private $dsn = "mysql:host=localhost;dbname=entrance-exam";
    private $user = "entrance-exam";
    private $pass = "H]s?8W72m+bk";
    protected $conn;
    public function __construct(){
        try{
            // PDO is a class
            $this->conn = new PDO($this->dsn,$this->user, $this->pass);
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}

?>