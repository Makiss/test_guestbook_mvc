<?php
namespace models;

use components\Db as Db;
use PDO;

class User
{

    public static function register($name, $email, $password, $country, $region, $city)
    {
        $db = Db::getConnection();

        $query = 'INSERT INTO users(username, email, password, country_id, region_id, city_id) VALUES(:username, :email, :password, :countryId, :regionId, :cityId)';

        $result = $db->prepare($query);
        $result->bindParam(':username', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->bindParam(':countryId', $country, PDO::PARAM_INT);
        $result->bindParam(':regionId', $region, PDO::PARAM_INT);
        $result->bindParam(':cityId', $city, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function checkSession()
    {
        if (isset($_SESSION['user'])) {
            header('Location: \\home\\');
        } else {
            return true;
        }
    }

    public static function sanitizeString($var)
    {
        $db = Db::getConnection();
        $var = str_ireplace("fuck", "****", $var);
        $var = strip_tags($var);
        $var = htmlentities($var);
        $var = stripslashes($var);
        return $var;
    }

    public static function checkName($name)
    {
        if (!$name) {
            return false;
        }
        return true;
    }

    public static function checkEmail($email)
    {
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    public static function checkEmailExists($email)
    {
        $db = Db::getConnection();
        $query = 'SELECT COUNT(*) FROM users WHERE email= :email';
        $result = $db->prepare($query);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn()) {
            return true;
        }
        return false;
    }

    public static function checkPassword($password)
    {
        if (strlen($password) < 8 || !preg_match('~[A-Z]~', $password)) {
            print_r(strlen($password));
            return false;
        }
        return true;
    }

    public static function checkRepeatPassword($password, $repeatPassword)
    {
        if (!($password === $repeatPassword)) {
            return false;
        }
        return true;
    }

    public static function checkUserdata($email, $password)
    {
        $db = Db::getConnection();

        $query = 'SELECT * FROM users WHERE email = :email AND password = :password';
        $result = $db->prepare($query);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->execute();

        $user = $result->fetch();
        if ($user) {
            return $user['user_id'];
        }
        return false;
    }

    public static function auth($userId)
    {
        $_SESSION['user'] = $userId;
    }

    public static function checkLogged()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        header('Location: \\user\\register');
    }

    public static function getLoggedUserData($userId)
    {
        $db = Db::getConnection();

        $query = 'SELECT * FROM users WHERE user_id= :userId';
        $result = $db->prepare($query);
        $result->bindParam(':userId', $userId, PDO::PARAM_INT);
        $result->execute();

        $row = $result->fetch();
        if ($row) {
            return $row;
        }
        return false;
    }

    public static function addMessage($userId, $userMessage, $currentTime)
    {
        $db = Db::getConnection();

        $query = 'INSERT INTO messages (user_id, user_message, message_date)
        VALUES(:userId, :userMessage, :messageDate)';
        $result = $db->prepare($query);
        $result->bindParam(':userId', $userId, PDO::PARAM_INT);
        $result->bindParam(':userMessage', $userMessage, PDO::PARAM_STR);
        $result->bindParam(':messageDate', $currentTime, PDO::PARAM_INT);
        $result->execute();

        return true;
    }

    public static function fetchCountries()
    {
        $db = Db::getConnection();

        $arrayOfStates = array();

        $query = 'SELECT * FROM countries';
        $result = $db->prepare($query);
        $result->execute();
        $rows = $result->rowCount();
        for ($j = 0; $j<$rows; $j++) {
            $chunkRow = $result->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT, $j);
            $arrayOfStates[] = $chunkRow;
        }
        return $arrayOfStates;
    }

    public static function fetchRegions()
    {
        $db = Db::getConnection();

        $arrayOfRegions = array();
        $query = "SELECT * FROM regions WHERE country_id='" . $_GET['country_id'] . "'";
        $result = $db->prepare($query);
        $result->execute();
        $rows = $result->rowCount();
        for ($j = 0; $j<$rows; $j++) {
            $chunkRow = $result->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT, $j);
            $arrayOfRegions[] = $chunkRow;
        }

        print_r(json_encode($arrayOfRegions));
    }

    public static function fetchCities()
    {
        $db = Db::getConnection();

        $arrayOfCities = array();
        $query = "SELECT * FROM cities WHERE region_id='" . $_GET['region_id'] . "'";
        $result = $db->prepare($query);
        $result->execute();
        $rows = $result->rowCount();
        for ($j = 0; $j<$rows; $j++) {
            $chunkRow = $result->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT, $j);
            $arrayOfCities[] = $chunkRow;
        }

        print_r(json_encode($arrayOfCities));
    }
}
