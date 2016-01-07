<?php
  function sanitizeString($var) {
    global $db_connection;
    $var = str_ireplace("fuck", "****", $var);
    $var = stripslashes($var);
    $var = htmlentities($var);
    $var = strip_tags($var);
    $var = $db_connection->real_escape_string($var);
    return $var;
  }

  function queryMysql($query) {
    global $db_connection;
    $result = $db_connection->query($query);
    if(!$result) {
      die($db_connection->error);
    }
    return $result;
  }
?>
