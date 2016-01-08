<?php
    session_start();
    if(!isset($_SESSION['user'])) {
        header("Location: index.php");
    }
    require_once 'inc/dbconnect.php';
    include_once 'inc/functions.php';
    $pageTitle = "Guestbook Home Page";
    include_once 'inc/head.php';

    $stmt = $dbConnection->prepare("SELECT * FROM users WHERE user_id= ?");
    $stmt->bind_param("s", $_SESSION['user']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $row = $result->fetch_array();

    if(isset($_POST['submit'])) {
        $userMessage = sanitizeString($dbConnection, $_POST['usermessage']);
        $userId = $_SESSION['user'];
        $currentTime = time();

        $stmt = $dbConnection->prepare("INSERT INTO messages (user_id, user_message, message_date) 
        VALUES(?, ?, ?)");
        $stmt->bind_param("sss", $userId, $userMessage, $currentTime);
        $stmt->execute();
        $stmt->close();
    }
?>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <a href="#" class="navbar-brand">GuestBook</a>
                </div>
                <div class="pull-right">
                    <ul class="navbar-nav nav">
                        <li>Hi there! You're currently logged as <span 
                        class="user-name"><?php echo $row['username']; ?>
                        </span>&nbsp;<a href="logout.php?logout">Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container container-message">
            <div class="row">
                <div class="col-xs-12 col-md-6 col-md-offset-3">
                    <form method="post">
                        <div class="form-group">
                            <label for="message">Message:</label>
                            <textarea id="message" class="form-control" 
                            rows="10" cols="40" name="usermessage" required>
                            </textarea>
                        </div>
                        <input type="submit" name="submit" class="btn 
                        btn-success btn-lg" value="Post">
                    </form>
    
                    <?php
                        $query = "SELECT * FROM messages";
                        $result = queryMysql($dbConnection, $query);
                        $rows = $result->num_rows;

                        if($rows) {
                            $query = "SELECT * FROM messages JOIN users 
                            ON users.user_id=messages.user_id ORDER BY 
                            message_date";
                            $result = queryMysql($dbConnection, $query);
                            $rows = $result->num_rows;
                            for($j = 0; $j < $rows; $j++) {
                                $result->data_seek($j);
                                $chunkRow = $result->fetch_array(MYSQLI_ASSOC);

                                if($chunkRow['is_visible']) {
                                    $dateSubmitted = date("jS F Y", 
                                    $chunkRow['message_date']);
                                    echo <<< _END
                                    <div class="user-post">
                                    <p>
                                        <strong>Posted by <a href="mailto:
                                        {$chunkRow['email']}">{$chunkRow['username']}
                                        </a> on $dateSubmitted</strong>
                                    </p>
                                    <p>
                                        {$chunkRow['user_message']}
                                    </p>
                                    </div>
_END;
                                }
                            } 
                        }
                    ?>
                </div>
            </div>
        </div>

<?php include_once 'inc/foot.php'; ?>
