
<?php if (isset($_SESSION['auth'])) { ?>

</body>

    <footer id="myFooter">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h2 class="logo">
                        <a href="../home/" target="_blank"> 
                            <img src="../assets/images/logowhite.png" alt="" width="200" height="200" class="">
                        </a>
                    </h2>
                </div>
                <div class="col-sm-2">
                    <h5>Features</h5>
                    <ul>
                        <li><a href="../home/" target="_blank">Home</a></li>
                        <li><a href="../dashboard/" target="_blank">Dashboard</a></li>
                        <li><a href="../profile-edit/" target="_blank">Edit Profile</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

<?php } ?>


<script src="../assets/vendor/js/jquery-3.4.1.min.js"></script>
<script src="../assets/vendor/js/popper.min.js"></script>
<script src="../assets/vendor/bootstrap-4.3.1/js/bootstrap.min.js"></script>

<?php if(isset($_SESSION['auth'])) { ?> 

<script src="../assets/js/check_inactive.js"></script>
    
<?php } ?>


</body>

</html>

<?php

if (isset($_SESSION['ERRORS']))
    $_SESSION['ERRORS'] = NULL;
if (isset($_SESSION['STATUS']))
    $_SESSION['STATUS'] = NULL;

?>