<?php
define('TITLE', "View User");
include '../assets/layouts/header.php';
check_verified();
if($_SESSION['level']!=0){
    header("Location: ../");
}

if(isset($_POST['delete']))
{
    $employee = mysqli_real_escape_string($conn, $_POST['delete']);
    $sql = 'DELETE FROM users WHERE id=? RETURNING department';
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt,"s",$employee);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    $result=mysqli_fetch_array($result);

    if($result)
    {
        $department = $result['department'];
        //departing the department count using 
        $sql1 = "UPDATE department SET count=count-1 WHERE id=?";
        $stmt1 = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt1, $sql1);
        mysqli_stmt_bind_param($stmt1,"s",$department);
        mysqli_stmt_execute($stmt1);
        $_SESSION['STATUS']['deletestatus'] = "User Deleted Successfully";
        header("Location: index.php");
        exit(0);
    }
    else
    {
        $_SESSION['STATUS']['deletestatus'] = "Error While Deleting... Please Try Again Later";
        header("Location: index.php");
        exit(0);
    }
}
?>