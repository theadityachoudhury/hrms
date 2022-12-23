<?php
session_start();

require '../../assets/includes/security_functions.php';
require '../../assets/includes/auth_functions.php';
check_verified();

require '../../assets/vendor/PHPMailer/src/Exception.php';
require '../../assets/vendor/PHPMailer/src/PHPMailer.php';
require '../../assets/vendor/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['update-profile'])) {

    /*
    * -------------------------------------------------------------------------------
    *   Securing against Header Injection
    * -------------------------------------------------------------------------------
    */

    foreach($_POST as $key => $value){

        $_POST[$key] = _cleaninjections(trim($value));
    }

    /*
    * -------------------------------------------------------------------------------
    *   Verifying CSRF token
    * -------------------------------------------------------------------------------
    */

    if (!verify_csrf_token()){

        $_SESSION['STATUS']['editstatus'] = 'Request could not be validated';
        header("Location: ../");
        exit();
    }


    require '../../assets/setup/db.inc.php';
    require '../../assets/includes/datacheck.php';

    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $level = $_POST['level'];
    if(isset($_POST['facebook'])){
        $facebook = $_POST['facebook'];
        $facebook = trim($facebook,'https://www.');
        $facebook = trim($facebook,"facebook.com/");
        $facebook = explode('/',$facebook);
        $facebook = $facebook[0];
    }
    else $facebook = NULL;
    if(isset($_POST['instagram'])){
        $instagam = $_POST['instagram'];
        $instagam = trim($instagam,'https://www.');
        $instagam = trim($instagam,"instagram.com");
        $instagam = explode('/',$instagam);
        $instagam = $instagam[0];
    }
    else $instagam = NULL;

    if (isset($_POST['gender'])) 
        $gender = $_POST['gender'];
    else
        $gender = NULL;


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $_SESSION['ERRORS']['emailerror'] = 'invalid email, try again';
        header("Location: ../view.php?id=$id");
        exit();
    } 
    if ($_SESSION['eemail'] != $email && !availableEmail($conn, $email)) {

        $_SESSION['ERRORS']['emailerror'] = 'email already taken';
        header("Location: ../view.php?id=$id");
        exit();
    }
    if ( $_SESSION['eusername'] != $username && !availableUsername($conn, $username)) {

        $_SESSION['ERRORS']['usernameerror'] = 'username already taken';
        header("Location: ../view.php?id=$id");
        exit();
    }
    else {
        /*
        * -------------------------------------------------------------------------------
        *   User Updation
        * -------------------------------------------------------------------------------
        */

        $sql = "UPDATE users 
            SET username=?,
            email=?, 
            first_name=?, 
            last_name=?, 
            gender=?, 
            profile_image=?,
            level=?,
            instagram=?,
            facebook=?";
            $sql .= " WHERE id=?;";

        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {

            $_SESSION['ERRORS']['scripterror'] = 'SQL ERROR';
            header("Location: ../view.php?id=$id");
            exit();
        } 
        else {
                mysqli_stmt_bind_param($stmt, "ssssssssss", 
                    $username,
                    $email,
                    $first_name,
                    $last_name,
                    $gender,
                    $FileNameNew,
                    $level,
                    $instagam,
                    $facebook,
                    $_POST['id']
                );

            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            $_SESSION['STATUS']['editstatus'] = 'profile successfully updated';
            header("Location: ../view.php?id=$id");
            exit();
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} 
else {

    header("Location: ../view.php?id=$id");
    exit();
}
