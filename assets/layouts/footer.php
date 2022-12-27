
<script src="<?php echo APP_LINK?>/assets/vendor/js/jquery-3.4.1.min.js"></script>
<script src="<?php echo APP_LINK?>/assets/vendor/js/popper.min.js"></script>
<!-- <script src="../assets/vendor/bootstrap-4.3.1/js/bootstrap.min.js"></script> -->
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<?php if(isset($_SESSION['auth'])) { ?> 

<script src="<?php echo APP_LINK?>/assets/js/check_inactive.js"></script>
    
<?php } ?>


</body>

</html>

<?php

if (isset($_SESSION['ERRORS']))
    $_SESSION['ERRORS'] = NULL;
if (isset($_SESSION['STATUS']))
    $_SESSION['STATUS'] = NULL;

?>