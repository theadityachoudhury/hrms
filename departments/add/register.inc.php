<?php

session_start();

require $_SERVER['DOCUMENT_ROOT'].'/assets/includes/auth_functions.php';
require $_SERVER['DOCUMENT_ROOT'].'/assets/includes/datacheck.php';
require $_SERVER['DOCUMENT_ROOT'].'/assets/includes/security_functions.php';

if(check_logged_in()){
    if (isset($_SESSION)) {
        if($_SESSION["auth"]!="verified"){
            header("Location: ../");
        }
        else{
            if($_SESSION["level"]!=0){
                header("Location: ../dashboard");
            }
        }
    }
    else {
        header("Location: ../");
    }
}


if (isset($_POST['depsubmit'])) {

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

        $_SESSION['STATUS']['depstatus'] = 'Request could not be validated';
        header("Location: ../");
        exit();
    }



    require $_SERVER['DOCUMENT_ROOT'].'/assets/setup/db.inc.php';
    
    //filter POST data
    function input_filter($data) {
        $data= trim($data);
        $data= stripslashes($data);
        $data= htmlspecialchars($data);
        return $data;
    }
    
    $depid = input_filter($_POST['depid']);
    $depname = input_filter($_POST['depname']);


    /*
    * -------------------------------------------------------------------------------
    *   Data Validation
    * -------------------------------------------------------------------------------
    */

    if (empty($depid) || empty($depname)) {

        $_SESSION['ERRORS']['formerror'] = 'required fields cannot be empty, try again';
        header("Location: ../add");
        exit();
    }else {

        if (!availabledepartmentid($conn, $depid)){

            $_SESSION['ERRORS']['depiderror'] = 'Department ID already exists';
            header("Location: ../add");
            exit();
        }
        if (!availabledapartmentname($conn, $depname)){

            $_SESSION['ERRORS']['depnameerror'] = 'Department Name Already Exists';
            header("Location: ../add");
            exit();
        }


        /*
        * -------------------------------------------------------------------------------
        *   User Creation
        * -------------------------------------------------------------------------------
        */

        $sql = "insert into department(id, dep_name) 
                values ( ?,?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {

            $_SESSION['ERRORS']['scripterror'] = 'SQL ERROR';
            header("Location: ../add");
            exit();
        } 
        else {
            mysqli_stmt_bind_param($stmt,"ss",$depid,$depname);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            $_SESSION['STATUS']['depstatus'] = 'Department Created Successfully';
            header("Location: ../add");
            exit();
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} 
else {

    header("Location: ../add");
    exit();
}
