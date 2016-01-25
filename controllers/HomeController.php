<?php
use models\Home as Home;
use models\User as User;

class HomeController
{
    public function actionIndex()
    {
        $userId = User::checkLogged();
        $currentTime = time();
        $row = User::getLoggedUserData($userId);

        if (isset($_POST['submit'])) {
            $userMessage = User::sanitizeString($_POST['usermessage']);
            User::addMessage($userId, $userMessage, $currentTime);
        }
        $arrayOfChunk = Home::showMessages();

        require_once(ROOT . '\\views\\home\\index.php');

        return true;
    }
}
