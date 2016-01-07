<?php
    function sanitizeString($connection, $var) {
        $var = str_ireplace("fuck", "****", $var);
        $var = stripslashes($var);
        $var = htmlentities($var);
        $var = strip_tags($var);
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
