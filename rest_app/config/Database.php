<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'my_blog';
    private $username = "root";
    private $password = "";
    private $connection;

   // DB connct
 
public function connect(){
        $this->connection = null;
    
            try {
                $this-> connection = new PDO ('mysql:host=' . $this->host . 'db_name=' . $this->db_name,
                $this->username, $this->password);
                $this->connection->setAttribute(PDO::AFTER_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e)
            {
            echo "Connection failed: " . $e->getMessage();
            }

            return $this->connection;
        }
    }





   
?>