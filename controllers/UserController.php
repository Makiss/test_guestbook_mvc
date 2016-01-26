<?php
use models\User as User;

class UserController
{
    public function actionRegister()
    {
        User::checkSession();

        if (isset($_POST['btn-signup'])) {
            $name = User::sanitizeString($_POST['uname']);
            $email = User::sanitizeString($_POST['email']);
            $pass = User::sanitizeString($_POST['pass']);
            $cpass = User::sanitizeString($_POST['cpass']);

            if (!User::checkName($name)) {
                $error .= 'Please enter your name!<br>';
            }

            if (!User::checkEmail($email)) {
                $error .= 'Please enter a valid email address!<br>';
            }

            if (User::checkEmailExists($email)) {
                $error .= 'That email address is already registered. Do
                you want to log in?<br>';
            } else {
                if (!User::checkPassword($pass)) {
                    $error .= 'Please enter password with at list 8 characters and one capital letter!<br>';
                }

                if (!User::checkRepeatPassword($pass, $cpass)) {
                    $error .= 'Your passwords are different! Please
                            check and repeat!<br>';
                }

                if ($error) {
                    $error = 'There was(were) error(s) in your sign up details:<br>' . $error;
                } else {
                    $pass = hash('ripemd128', $pass);
                    $cpass = hash('ripemd128', $cpass);
                    $result = User::register($name, $email, $pass);
                    $message = 'You\'re registered!<br>Now you can log in!';
                }
            }
        }

        if (isset($_POST['btn-login'])) {
            $email = User::sanitizeString($_POST['logemail']);
            $pass = hash('ripemd128', User::sanitizeString($_POST['logpass']));

            $userId = User::checkUserdata($email, $pass);
            if (!$userId) {
                $error = 'We could not find a user with such email address and password. Please try again.';
            } else {
                User::auth($userId);

                header('Location: \\home\\');
            }
        }

        require_once(ROOT . '\\views\\user\\index.php');
        return true;
    }

    public function actionLogout()
    {
        session_destroy();
        unset($_SESSION['user']);
        header('Location: \\user\\');
    }
}
