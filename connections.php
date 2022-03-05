<?php

class Database{
    private $dsn = "mysql:host=localhost;dbname=entrance-exam";
    private $user = "root";
    private $pass = "";
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