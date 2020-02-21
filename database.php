<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
    $connection = new PDO("mysql:host=$servername;dbname=my_users", $username, $password);
    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?> 