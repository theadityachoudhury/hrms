<?php

define('TITLE', 'Verified Account');
include '../assets/layouts/navbar.php';
check_verified();
?>


<main role="main" class="container">

    <div class="row">
        <div class="shadow-lg box-shadow col-sm-7 px-5 m-5 bg-light rounded align-self-center verify-message">
            <?php if (isset($_SESSION['STATUS']['loginstatus'])) { ?>
                <h1><?php echo $_SESSION['STATUS']['loginstatus']; ?></h1>
                <?php
                    require '../assets/setup/db.inc.php';
                    $selector = bin2hex(random_bytes(8));
                    $token = random_bytes(32);
                    $url = "localhost/reset-password/?selector=" . $selector . "&validator=" . bin2hex($token);
                    $expires = 'DATE_ADD(NOW(), INTERVAL 1 HOUR)';

                    $email = $_SESSION['email'];

                    $sql = "SELECT id FROM users WHERE email=?;";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)){

                        $_SESSION['ERRORS']['sqlerror'] = 'SQL ERROR';
                        header("Location: ../");
                        exit();
                    }
                    else {
                
                        mysqli_stmt_bind_param($stmt, "s", $email);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                    }
                
                
                    $sql = "DELETE FROM auth_tokens WHERE user_email=? AND auth_type='password_reset';";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                
                        $_SESSION['ERRORS']['sqlerror'] = 'SQL ERROR';
                        header("Location: ../");
                        exit();
                    }
                    else {
                
                        mysqli_stmt_bind_param($stmt, "s", $email);
                        mysqli_stmt_execute($stmt);
                    }
                
                
                    $sql = "INSERT INTO auth_tokens (user_email, auth_type, selector, token, expires_at) 
                            VALUES (?, 'password_reset', ?, ?, " . $expires . ");";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                
                        $_SESSION['ERRORS']['sqlerror'] = 'SQL ERROR';
                        header("Location: ../");
                        exit();
                    }
                    else {
                        
                        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($stmt, "sss", $email, $selector, $hashedToken);
                        mysqli_stmt_execute($stmt);
                    }
                
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                    session_unset();
                    session_destroy();
                ?>
                <h1><a href="http://<?php echo $url?>">Click Here</a> to set your new password<h1>
            <?php } elseif (check_verified()); ?>
                <h1><?php echo 'Your Account Is Verified'; ?></h1>
        
        </div>
    </div>
</main>


<?php include '../assets/layouts/footer.php';

?>
