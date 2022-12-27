<?php
define('TITLE', 'Add Department');
include '../../assets/layouts/navbar.php';
if(check_logged_in()){
    if (isset($_SESSION)) {
        if($_SESSION["auth"]!="verified"){
            header("Location: ../");
        }
        else{
            if($_SESSION["level"]!=0){
                header("Location: ../");
            }
        }
    }
    else {
        header("Location: ../");
    }
}
?>


<div class="container">
    <div class="row">
        <div class="col-md-4">

        </div>
        <div class="col-lg-4">

            <form class="form-auth" action="register.inc.php" method="post" enctype="multipart/form-data">

                <?php insert_csrf_token(); ?>


                <h6 class="h3 mt-3 mb-3 font-weight-normal text-muted text-center">Add A Department</h6>

                <div class="text-center mb-3">
                    <small class="text-success font-weight-bold">
                        <?php if (isset($_SESSION['STATUS']['depstatus'])) { ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong><?php echo $_SESSION['STATUS']['depstatus'] ?></strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php } ?>
                    </small>
                </div>

                <div class="form-group mb-3">
                    <div class="mb-2"><label for="depid" class="sr-only">Department ID</label></div>
                    <input type="text" id="depid" name="depid" class="form-control" placeholder="Department ID" required autofocus autocomplete='off'>
                    <sub class="text-danger">
                        <?php if (isset($_SESSION['ERRORS']['formerror'])) {
                            echo $_SESSION['ERRORS']['formerror'];
                        } ?>
                    </sub>
                </div>

                <div class="form-group mb-3">
                    <div class="mb-2"><label for="depname" class="sr-only">Department Name</label></div>
                    <input type="text" id="depname" name="depname" class="form-control" placeholder="Department Name" required autofocus autocomplete="off">
                    <sub class="text-danger">
                        <?php if (isset($_SESSION['ERRORS']['formerroe'])) {
                            echo $_SESSION['ERRORS']['formerror'];
                        } ?>
                    </sub>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name='depsubmit'>Add Department</button>
            </form>
        </div>
        <div class="col-md-4">
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/assets/layouts/footer.php'; ?>