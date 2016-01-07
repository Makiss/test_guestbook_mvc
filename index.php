<?php
    session_start();
    if(isset($_SESSION['user']) != "") {
        header("Location: home.php");
    }

    include_once 'login.php';
    $pageTitle = "Sign In Page";
    include_once 'inc/head.php';
?>

    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle" data-toggle="collapse" 
                data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="#" class="navbar-brand">GuestBook</a>
            </div>
            <div class="collapse navbar-collapse">
                <form method="post" class="navbar-form navbar-right">
                    <div class="form-group">
                        <input type="email" name="logemail" id="logemail" 
                        class="form-control" placeholder="Email" value=
                        "<?php echo addslashes($_POST['logemail']); ?>">
                    </div>
                    <div class="form-group">
                        <input type="password" name="logpass" class=
                        "form-control" placeholder="Password" value=
                        "<?php echo addslashes($_POST['logpassword']); ?>">
                    </div>
                    <input type="submit" name="btn-login" class="btn 
                    btn-success btn-lg" value="Sign In">
                </form>
            </div>
        </div>
    </div>
    <div class="container container-signup">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 email-form">
                <h1>GUESTBOOK</h1>
                <form method="post">
                    <h3>SIGN UP</h3>
                    <?php
                        if($error) {
                            echo '<div class="alert alert-danger">' . 
                            $error . '</div>';
                        }
                        if($message) {
                            echo '<div class="alert alert-success">' . 
                            $message . '</div>';
                        }
                    ?>
                    <div class="form-group">
                        <input type="text" name="uname" class="form-control" 
                        placeholder="User Name" value="<?php echo $uname; ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" 
                        placeholder="Your Email" value="<?php echo $email; ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="pass" class="form-control" 
                        placeholder="Your Password" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="cpass" class="form-control" 
                        placeholder="Confirm Password" required>
                    </div>
                    <input type="submit" name="btn-signup" class="btn 
                    btn-success btn-lg" value="Sign Me Up">
                </form>
            </div>
        </div>
    </div>
 
<?php include_once 'inc/foot.php'; ?>
