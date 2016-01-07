<?php
    $dbHost = "localhost";
    $dbUser = "syomushkin";
    $dbPass = "26041989smn";
    $dbName = "guestbook";
  
    $dbConnection = new mysqli($dbHost,$dbUser,$dbPass,$dbName);
    
    if($dbConnection->connect_error) {
        die("ERROR : -> " . $dbConnection->connect_error);
    }
?>
