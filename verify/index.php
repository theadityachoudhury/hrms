<?php

define('TITLE', "Verify Email");
include '../assets/layouts/navbar.php';
check_logged_in_butnot_verified(); 

?>


<main role="main" class="container">

    <div class="row">
        <div class="shadow-lg box-shadow col-sm-7 px-5 m-5 bg-light rounded align-self-center verify-message">

            <form action="includes/sendverificationemail.inc.php" method="post">

                <?php insert_csrf_token(); ?>
                <div class="mt-5">
                <h5 class="text-center mb-5 text">Verify Your Email Address</h5>
                </div>

                <p>
                    Before proceeding, please check your email for a verification link. If you did not receive the email,
                    <span class="btn-group" role="group" aria-label="Default button group">
                        <button type="submit" class="btn btn-outline-dark" name="verifysubmit">
                            click here to send another
                        </button>
</span>
                </p>
                <br>
                <div class="text-center mt-5 mb-5">
                    <h6 class="text-success">
                        <?php
                            if (isset($_SESSION['STATUS']['verify']))
                                echo $_SESSION['STATUS']['verify'];

                        ?>

                        <?php
                            if (isset($_SESSION['STATUS']['mailstatus']))
                                echo $_SESSION['STATUS']['mailstatus'];
                        ?>
                    </h6>
                </div>

            </form>

        </div>
    </div>
</main>


<?php

include '../assets/layouts/footer.php'

?>