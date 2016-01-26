<?php
    $pageTitle = "Sign In Page";
    include_once 'views\\inc\\head.php';
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
                <a href="/user/register" class="navbar-brand">GuestBook</a>
            </div>
            <div class="collapse navbar-collapse">
                <form method="post" class="navbar-form navbar-right">
                    <div class="form-group">
                        <input type="email" name="logemail" id="logemail"
                        class="form-control" placeholder="Email" value=
                        "<?php if (isset($_POST['logemail'])) {
                            echo addslashes($_POST['logemail']);
} ?>">
                    </div>
                    <div class="form-group">
                        <input type="password" name="logpass" class=
                        "form-control" placeholder="Password" value=
                        "<?php if (isset($_POST['logpassword'])) {
                            echo addslashes($_POST['logpassword']);
} ?>">
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
                    <?php
                    if (isset($message)) {
                        echo '<div class="alert alert-success" id="center-message">' .
                        $message . '</div>';
                    } else {
                    ?>
                    <h3>SIGN UP</h3>
                    <?php
                    if (isset($error)) {
                        echo '<div class="alert alert-danger">' .
                        $error . '</div>';
                    }
                    ?>
                    <div class="form-group">
                    <input type="text" name="uname" class="form-control"
                    placeholder="User Name" value="<?php if (isset($name)) {
                        echo $name;
} ?>" required>
                    </div>
                    <div class="form-group">
                    <input type="email" name="email" class="form-control"
                    placeholder="Your Email" value="<?php if (isset($name)) {
                        echo $email;
} ?>" required>
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
                    <?php
                    }
                ?>
                </form>
            </div>
        </div>
    </div>

<?php include_once 'views\\inc\\foot.php'; ?>
