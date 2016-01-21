<?php
    function sanitizeString($connection, $var) {
        $var = str_ireplace("fuck", "****", $var);        
        $var = strip_tags($var);
        $var = htmlentities($var);
        $var = stripslashes($var);
        $var = $connection->real_escape_string($var);
        return $var;
    }

    function queryMysql($connection, $query) {
        $result = $connection->query($query);
        if(!$result) {
            die($connection->error);
        }
        return $result;
    }
?>
