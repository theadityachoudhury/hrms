<?php
define('TITLE',"HRMS Login");
include '../assets/layouts/navbar.php';
check_logged_out();
?>

<div class="container">
    <div class="row">
        <div class="col-sm-4">

        </div>
        <div class="col-sm-4">
            <!-- <form class="form-auth" action="../api/login/" method="post"> -->
            <form class="form-auth" action="login.inc.php" method="post">

                <?php insert_csrf_token(); ?>

                <div class="text-center">
                    <img class="mb-1" src="../assets/images/logo.png" alt="" width="130" height="130">
                </div>

                <h6 class="h3 mb-5 font-weight-normal text-muted text-center">Login to your Account</h6>

                <div class="text-center mb-3">
                    <small class="text-success font-weight-bold">
                        <?php
                            if (isset($_SESSION['STATUS']['loginstatus']))
                                echo $_SESSION['STATUS']['loginstatus'];

                        ?>
                    </small>
                </div>

                <div class="form-group mb-3">
                    <label for="username" class="sr-only">Username</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus autocomplete="off">
                    <sub class="text-danger">
                        <?php
                            if (isset($_SESSION['ERRORS']['nouser']))
                                echo $_SESSION['ERRORS']['nouser'];
                        ?>
                    </sub>
                </div>

                <div class="form-group mb-3">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                    <sub class="text-danger">
                        <?php
                            if (isset($_SESSION['ERRORS']['wrongpassword']))
                                echo $_SESSION['ERRORS']['wrongpassword'];
                        ?>
                    </sub>
                </div>

                <div class="ml-4 my-1 mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="rememberme" id="rememberme">
                        <label class="form-check-label" for="rememberme">
                            Remember Me
                        </label>
                    </div>
                </div>
                <div class="d-grid gap-2">
                <button class="btn btn-lg btn-primary btn-block" type="submit" value="loginsubmit" name="loginsubmit">Login</button>
                </div>
                <p class="mt-3 text-muted text-center"><a href="../reset-password/">Forgot Password?</a></p>
                
            </form>
        </div>
        <div class="col-sm-4">

        </div>
    </div>
</div>

<?php include '../assets/layouts/footer.php' ?>