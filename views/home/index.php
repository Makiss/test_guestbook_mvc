<?php
    $pageTitle = "Guestbook Home Page";
    include_once 'views\\inc\\head.php';
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
                        </span>&nbsp;<a href="<?php echo substr($_SERVER['REQUEST_URI'], 0, 13);?>/user/logout/">Sign Out</a></li>
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
                    if (!empty($arrayOfChunk)) {
                        for ($j = 0; $j < count($arrayOfChunk); $j++) {
                            $dateSubmitted = date("jS F Y", $arrayOfChunk[$j]['message_date']);
                            echo <<< _END
                                    <div class="user-post">
                                    <p>
                                        <strong>Posted by <a href="mailto:
                                        {$arrayOfChunk[$j]['email']}">{$arrayOfChunk[$j]['username']}
                                        </a> on $dateSubmitted</strong>
                                    </p>
                                    <p>
                                        {$arrayOfChunk[$j]['user_message']}
                                    </p>
                                    </div>
_END;
                        }
                    } else {
                        echo 'The guestbook is empty.';
                    }
                    ?>
                </div>
            </div>
        </div>

<?php include_once 'views\\inc\\foot.php'; ?>
