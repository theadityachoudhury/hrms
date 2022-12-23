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

    $username = $_POST['username'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
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


    $oldPassword = $_POST['password'];
    $newpassword = $_POST['newpassword'];
    $passwordrepeat  = $_POST['confirmpassword'];


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $_SESSION['ERRORS']['emailerror'] = 'invalid email, try again';
        header("Location: ../");
        exit();
    } 
    if ($_SESSION['email'] != $email && !availableEmail($conn, $email)) {

        $_SESSION['ERRORS']['emailerror'] = 'email already taken';
        header("Location: ../");
        exit();
    }
    if ( $_SESSION['username'] != $username && !availableUsername($conn, $username)) {

        $_SESSION['ERRORS']['usernameerror'] = 'username already taken';
        header("Location: ../");
        exit();
    }
    else {
        /*
        * -------------------------------------------------------------------------------
        *   Password Updation
        * -------------------------------------------------------------------------------
        */

        if( !empty($oldPassword) || !empty($newpassword) || !empty($passwordRepeat)){

            include 'password-edit.inc.php';
        }
        
        if (isset($passwordUpdated)) {

            /*
            * -------------------------------------------------------------------------------
            *   Sending notification email on password update
            * -------------------------------------------------------------------------------
            */

            $to = $_SESSION['email'];
            $subject = 'Password Updated';
            
            /*
            * -------------------------------------------------------------------------------
            *   Using email template
            * -------------------------------------------------------------------------------
            */

            $mail_variables = array();

            $mail_variables['APP_NAME'] = APP_NAME;
            $mail_variables['email'] = $_SESSION['email'];

            $message = file_get_contents("./template_notificationemail.php");

            foreach($mail_variables as $key => $value) {
                
                $message = str_replace('{{ '.$key.' }}', $value, $message);
            }
        
            $mail = new PHPMailer(true);
        
            try {
        
                $mail->isSMTP();
                $mail->Host = MAIL_HOST;
                $mail->SMTPAuth = true;
                $mail->Username = MAIL_USERNAME;
                $mail->Password = MAIL_PASSWORD;
                $mail->SMTPSecure = MAIL_ENCRYPTION;
                $mail->Port = MAIL_PORT;
        
                $mail->setFrom(MAIL_USERNAME, APP_NAME);
                $mail->addAddress($to, APP_NAME);
        
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $message;
        
                $mail->send();
            } 
            catch (Exception $e) {
        
                
            }
        }


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
            instagram=?,
            facebook=?";

        if (isset($passwordUpdated)){

            $sql .= ", password=?
                    WHERE id=?;";
        }
        else{

            $sql .= " WHERE id=?;";
        }

        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {

            $_SESSION['ERRORS']['scripterror'] = 'SQL ERROR';
            header("Location: ../");
            exit();
        } 
        else {

            if (isset($passwordUpdated)){

                $hashedPwd = password_hash($newpassword, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "ssssssssss", 
                    $username,
                    $email,
                    $first_name,
                    $last_name,
                    $gender,
                    $FileNameNew,
                    $instagam,
                    $facebook,
                    $hashedPwd,
                    $_SESSION['id']
                );
            }
            else{

                mysqli_stmt_bind_param($stmt, "sssssssss", 
                    $username,
                    $email,
                    $first_name,
                    $last_name,
                    $gender,
                    $FileNameNew,
                    $instagam,
                    $facebook,
                    $_SESSION['id']
                );
            }

            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);


            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['gender'] = $gender;
            $_SESSION['profile_image'] = $FileNameNew;
            // if($_SESSION['instagram']==NULL) unset($_SESSION['instagram']);
            $_SESSION['instagram'] = $instagam;
            // if($_SESSION['facebook']==NULL) unset($_SESSION['facebook']);
            $_SESSION['facebook'] = $facebook;

            $_SESSION['STATUS']['editstatus'] = 'profile successfully updated';
            header("Location: ../");
            exit();
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} 
else {

    header("Location: ../");
    exit();
}
