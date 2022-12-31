<?php
define('TITLE', "View User");
include '../assets/layouts/navbar.php';
check_verified();
if($_SESSION['level']==2){
    header("Location: ../");
}
?>


<div class="container">
    <div class="row">
        <div class="col-lg-7">
            <form class="form-auth" action="includes/profile-edit.inc.php" method="post" enctype="multipart/form-data" autocomplete="off">

                <?php insert_csrf_token(); ?>
                <div class="text-center">
                    <small class="text-success font-weight-bold">
                        <?php
                            if (isset($_SESSION['STATUS']['editstatus']))
                                echo $_SESSION['STATUS']['editstatus'];

                        ?>
                    </small>
                </div>

                
                <?php 
                    if(isset($_GET['id'])){
                        $id = mysqli_real_escape_string($conn, $_GET['id']);
                        $query = "SELECT * FROM users WHERE id='$id' ";
                        $query_run = mysqli_query($conn, $query);
                        if(mysqli_num_rows($query_run) > 0)
                        {
                            $employee = mysqli_fetch_array($query_run);
                ?> 
                <h6 class="h3 mt-3 mb-3 font-weight-normal text-muted text-center">Edit <?php echo $employee['username']?>'s Profile</h6>

                    <div class="form-group mb-3">
                        <div class="mb-1"><label for="id">ID</label></div>
                        <input type="text" id="id" name="id" class="form-control" placeholder="ID" value="<?php echo $employee['id']; ?>" autocomplete="off" readonly>
                        <sub class="text-danger">
                            <?php
                                if (isset($_SESSION['ERRORS']['iderror']))
                                    echo $_SESSION['ERRORS']['iderror'];

                            ?>
                        </sub>
                    </div>

                    <div class="form-group mb-3">
                    <div class="mb-1"><label for="username">Username</label></div>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Username" value="<?php echo $employee['username']; ?>" autocomplete="off" readonly>
                        <sub class="text-danger">
                            <?php
                                if (isset($_SESSION['ERRORS']['usernameerror']))
                                    echo $_SESSION['ERRORS']['usernameerror'];

                            ?>
                        </sub>
                    </div>

                    <div class="form-group mb-3">
                    <div class="mb-1"><label for="email">E-Mail</label></div>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email address" value="<?php echo $employee['email']; ?>">
                        <sub class="text-danger">
                            <?php
                                if (isset($_SESSION['ERRORS']['emailerror'])){
                                    echo $_SESSION['ERRORS']['emailerror'];
                                    echo $_SESSION['eemail'];

                                }?>
                        </sub>
                    </div>

                    <div class="form-group mb-3">
                    <div class="mb-1"><label for="first_name">First Name</label></div>
                        <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name" value="<?php echo $employee['first_name']; ?>">
                    </div>

                    <div class="form-group mb-3">
                    <div class="mb-1"><label for="last_name">Last Name</label></div>
                        <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name" value="<?php echo $employee['last_name']; ?>">
                    </div>

                    <div class="form-group mb-3">
                    <div class="mb-1"><label for="level">Permission Level</label></div>
                    <?php if($_SESSION['level']==1 || $_SESSION['id']==$id){?>
                        <input type="text" id="level" name="level" class="form-control" placeholder="level" value="<?php  
                            if($employee['level']==0)
                            echo "Super Admin";
                            else if($employee['level']==1)
                            echo "HOD/Admin";
                            else if($employee['level']==2)
                            echo "Employee";
                        
                        ?>" readonly>
                    <?php } else if($_SESSION['level']==0 && $_SESSION['id']!=$id){?>
                    <select id="level" name="level" class="form-select" placeholder="Level">
                        <option type="number" value="0" <?php if($employee['level']==0){?>selected<?php }?>>Super Admin</option>
                        <option type="number" value="1" <?php if($employee['level']==1){?>selected<?php }?>>Admin/HOD</option>
                        <option type="number" value="2" <?php if($employee['level']==2){?>selected<?php }?>>Employee</option>
                    </select>
                        <?php } ?>
                    </div>


                    <div class="form-group mb-3">
                    <div class="mb-1"><label for="level">Department</label></div>
                    <?php if($_SESSION['level']==1 || $_SESSION['id']==$id){?>
                        <input type="text" id="level" name="level" class="form-control" placeholder="level" value="<?php  
                            echo $employee['department'];
                        
                        ?>" readonly>
                    <?php } else if($_SESSION['level']==0 && $_SESSION['id']!=$id){?>
                        <input type="text" id="level" name="level" class="form-control" placeholder="level" value="<?php  
                            echo $employee['department'];?>"
                        <?php } ?>
                    </div>


                    <div class="form-group mb-5">
                        <label>Gender</label>
                        <div class="custom-control custom-radio custom-control">
                            <input type="radio" id="male" name="gender" class="custom-control-input" value="m" <?php if ($employee['gender'] == 'm') echo 'checked' ?>>
                            <label class="custom-control-label" for="male">Male</label>
                        </div>
                        <div class="custom-control custom-radio custom-control">
                            <input type="radio" id="female" name="gender" class="custom-control-input" value="f" <?php if ($employee['gender'] == 'f') echo 'checked' ?>>
                            <label class="custom-control-label" for="female">Female</label>
                        </div>
                    </div>
                    <hr>
                    <span class="h5 font-weight-normal text-muted mb-4">Social Media Section</span>
                    <div class="form-group mt-2">
                        <input type="text" id="facebook" name="facebook" class="form-control" placeholder="Facebook Link" 
                        value="<?php if(isset($employee['facebook'])){echo "https://www.facebook.com/";echo $employee['facebook'];}?>">
                    </div>
                    <div class="form-group mt-2">
                        <input type="text" id="instagram" name="instagram" class="form-control mb-5" placeholder="Instagram Link" 
                        value="<?php if(isset($employee['instagram'])){echo "https://instagram.com/";echo $employee['instagram'];}?>">
                    </div>
                    
                <?php }?>
                <?php if($_SESSION['level']==0 && mysqli_num_rows($query_run) > 0){?>

                    <div class="form-group mb-3">
                    <div class="mb-1"><label for="last_name">Created At</label></div>
                        <input type="text" id="created-at" name="created-at" class="form-control" placeholder="Created At" value="<?php echo $employee['created_at']; ?>" readonly>
                    </div>

                    <div class="form-group mb-3">
                    <div class="mb-1"><label for="last_name">Verified At</label></div>
                        <input type="text" id="verified-at" name="verified-at" class="form-control" placeholder="Verified At" value="<?php echo $employee['verified_at']; ?>" readonly>
                    </div>

                    <div class="form-group mb-3">
                    <div class="mb-1"><label for="last-login">Last Login At</label></div>
                        <input type="text" id="last-login" name="last-login" class="form-control" placeholder="Last Login" value="<?php echo $employee['last_login_at']; ?>" readonly>
                    </div>

                    <div class="form-group mb-3">
                    <div class="mb-1"><label for="deleted_at">Deleted At</label></div>
                        <input type="text" id="deleted_at" name="deleted_at" class="form-control" placeholder="Deleted At" value="<?php echo $employee['deleted_at']; ?>" readonly>
                    </div>

                <?php }?>
                <?php if(mysqli_num_rows($query_run) > 0){?>
                <button class="btn btn-lg btn-primary btn-block mb-5" type="submit" name='update-profile'>Confirm Changes</button>
                <?php }} ?>
                
            </form>

        </div>
        <div class="col-md-4">

        </div>
    </div>
</div>

<?php 
if(isset($_GET['id']) && mysqli_num_rows($query_run) > 0){
$_SESSION['eid'] = $employee['id'];
$_SESSION['eusername'] = $employee['username'];
$_SESSION['eemail'] = $employee['email'];
$_SESSION['efirst_name'] = $employee['first_name'];
$_SESSION['elast_name'] = $employee['last_name'];
$_SESSION['egender'] = $employee['gender'];
$_SESSION['elevel'] = $employee['level'];
$_SESSION['everified_at'] = $employee['verified_at'];
$_SESSION['ecreated_at'] = $employee['created_at'];
$_SESSION['eupdated_at'] = $employee['updated_at'];
$_SESSION['edeleted_at'] = $employee['deleted_at'];
$_SESSION['elast_login_at'] = $employee['last_login_at'];
$_SESSION['einstagram'] = $employee['instagram'];
$_SESSION['efacebook'] = $employee['facebook'];
$_SESSION['edepartment'] = $employee['department'];
}
?>



<?php

include '../assets/layouts/footer.php';

?>