<?php 
// namespace todolist\config;
// use PDO;
// use PDOException;
require_once('./config/config.php');

// i dont want to create instance on this class
abstract class Database{
    protected $conn;

    public function connect()
    {
        try {
            $this->conn = new PDO(DSN, USERNAME, PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_PERSISTENT, true);
            return $this->conn;

        } catch (PDOException $pex) {
           die("Connection failed". $pex->getMessage());
           
        }
    }

    public function disconnect()
    {
        $this->conn = null;
    }
}