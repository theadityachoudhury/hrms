<?php
define('TITLE', 'Signup');
include '../assets/layouts/navbar.php';
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
$prepass = bin2hex(random_bytes(6));
?>


<div class="container">
    <div class="row">
        <div class="col-md-4">

        </div>
        <div class="col-lg-4">

            <form class="form-auth" action="register.inc.php" method="post" enctype="multipart/form-data">

                <?php insert_csrf_token(); ?>


                <h6 class="h3 mt-3 mb-3 font-weight-normal text-muted text-center">Create an Account</h6>

                <div class="text-center mb-3">
                    <small class="text-success font-weight-bold">
                        <?php if (isset($_SESSION['STATUS']['signupstatus'])) { ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong><?php echo $_SESSION['STATUS']['signupstatus'] ?></strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php } ?>
                    </small>
                </div>

                <div class="form-group mb-3">
                    <label for="username" class="sr-only">Employee ID</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus autocomplete='off'>
                    <sub class="text-danger">
                        <?php if (isset($_SESSION['ERRORS']['usernameerror'])) {
                            echo $_SESSION['ERRORS']['usernameerror'];
                        } ?>
                    </sub>
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="sr-only">Email address</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required autofocus autocomplete="off">
                    <sub class="text-danger">
                        <?php if (isset($_SESSION['ERRORS']['emailerror'])) {
                            echo $_SESSION['ERRORS']['emailerror'];
                        } ?>
                    </sub>
                </div>

                <div class="alert alert-primary alert-dismissible fade show mb-3" role="alert">
                    <strong>Note:- </strong> If no level is selected it is defaulted to Employee!!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                <div class="form-group mb-3">
                    <label for="level" class="sr-only" required>Level</label>
                    <select id="level" name="level" class="form-select" placeholder="Level" required>
                        <option type="number" value="2">Level</option>
                        <option type="number" value="0">Super Admin</option>
                        <option type="number" value="1">Admin/HOD</option>
                        <option type="number" value="2">Employee</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <select for="department" id="department" name="department" class="form-select form-control" aria-label="Default select example" required>
                        <option>Select Department</option>
                        <optgroup label="For Super Admins Only">
                            <option value="all">Admin Account/Maintainer</option>
                        </optgroup>
                        <optgroup label="Engineering">
                            <option value="cse">Computer Science</option>
                            <option value="electrical">Electrical</option>
                            <option value="mech">Mechanical</option>
                            <option value="civil">Civil</option>
                        </optgroup>
                        <optgroup label="Medical">
                            <option value="bds">Dental</option>
                            <option value="mbbs">KIMS</option>
                        </optgroup>
                    </select>
                </div>
                <hr>
                <div class="h5 mb-3 font-weight-normal text-muted text-left">Password</div>
                <div class="form-group mb-3">
                    <label for="password" class="sr-only">Password</label>
                    <input type="text" id="password" name="password" class="form-control" placeholder="Password" value = "<?php echo $prepass?>" required>
                </div>
                

                <div class="form-group mb-4">
                    <label for="confirmpassword" class="sr-only">Confirm Password</label>
                    <input type="text" id="confirmpassword" name="confirmpassword" class="form-control" placeholder="Confirm Password" value = "<?php echo $prepass?>" required>
                    <sub class="text-danger mb-4">
                        <?php if (isset($_SESSION['ERRORS']['passworderror'])) {
                            echo $_SESSION['ERRORS']['passworderror'];
                        } ?>
                    </sub>
                </div>

                <hr>
                <div class="h5 mb-3 font-weight-normal text-muted text-left">Optional</div>

                <div class="form-group mb-3">
                    <label for="first_name" class="sr-only">First Name</label>
                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name">
                </div>

                <div class="form-group mb-3">
                    <label for="last_name" class="sr-only">Last Name</label>
                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name">
                </div>


                <div class="form-group mb-3">
                    <label>Gender</label>

                    <div class="custom-control custom-radio custom-control">
                        <input type="radio" id="male" name="gender" class="custom-control-input" value="m">
                        <label class="custom-control-label" for="male">Male</label>
                    </div>
                    <div class="custom-control custom-radio custom-control">
                        <input type="radio" id="female" name="gender" class="custom-control-input" value="f">
                        <label class="custom-control-label" for="female">Female</label>
                    </div>
                </div>

                <button class="btn btn-lg btn-primary btn-block" type="submit" name='signupsubmit'>Signup</button>
            </form>
        </div>
        <div class="col-md-4">
        </div>
    </div>
</div>






<?php include '../assets/layouts/footer.php'; ?>


<script type="text/javascript">
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);

            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#avatar").change(function() {
        console.log("here");
        readURL(this);
    });
</script>