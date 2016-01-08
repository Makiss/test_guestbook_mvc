<?php
    session_start();

    require_once 'inc/dbconnect.php';
    include_once 'inc/functions.php';

    if(isset($_POST['btn-login'])) {
        $stmt = $dbConnection->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);

        $email = sanitizeString($dbConnection, $_POST['logemail']);
        $upass = hash('ripemd128', sanitizeString($dbConnection, $_POST['logpass']));
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $row = $result->fetch_array();
        if($row['password'] == $upass) {
            $_SESSION['user'] = $row['user_id'];
            header("Location: home.php");
        } else { 
            $error .= "We could not find a user with such email address
            and password. Please try again.";
        }
    }

    if(isset($_POST['btn-signup'])) {
        if(!$_POST['uname']) {
            $error .= "Please enter your name!<br>";
        }

        if(!$_POST['email']) {
            $error .= "Please enter your email address!<br>";
        } else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error .= "Please enter a valid email address!<br>";
        }

        if(!$_POST['pass']) {
            $error .= "Please enter your password!<br>";
        }

        if($error) {
            $error = "There was(were) error(s) in your sign up details:<br>" 
            . $error;
        } else {
            $stmt = $dbConnection->prepare("SELECT * FROM users WHERE email= ?");
            $stmt->bind_param("s", $email);

            $uname = sanitizeString($dbConnection, $_POST['uname']);
            $email = sanitizeString($dbConnection, $_POST['email']);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            $rows = mysqli_num_rows($result);

            if($rows) {
                $error = "That email address is already registered. Do 
                you want to log in?";
            } else {
                if(strlen($_POST['pass']) < 8) {
                    $error .= "Please enter password with at list 8 characters!<br>";
                } else if(!preg_match('`[A-Z]`', $_POST['pass'])) { 
                    $error .= "Please use at least one capital letter in 
                    your password!<br>";
                } else {
                    $upass = hash('ripemd128', sanitizeString($dbConnection, $_POST['pass']));
                    $cpass = hash('ripemd128', sanitizeString($dbConnection, $_POST['cpass']));

                    if($upass === $cpass) {
                        $stmt = $dbConnection->prepare("INSERT INTO users(username,email,password) 
                        VALUES(?,?,?)");
                        $stmt->bind_param("sss", $uname, $email, $upass);
                        $stmt->execute();
                        $stmt->close();

                        $_SESSION['user'] = mysqli_insert_id($dbConnection);
                        header("Location: home.php");
                    } else {
                        $error = "Your passwords are different! Please 
                        check and repeat!";
                    }
                }
            }
        }
    }
$dbConnection->close();
?>
