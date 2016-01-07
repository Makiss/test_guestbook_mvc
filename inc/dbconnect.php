<?php
  $db_host = "localhost";
  $db_user = "syomushkin";
  $db_pass = "26041989smn";
  $db_name = "guestbook";
  
  $db_connection = new mysqli($db_host,$db_user,$db_pass,$db_name);
    
  if($db_connection->connect_error) {
    die("ERROR : -> " . $db_connection->connect_error);
  }
?>
