<?php

if (isset($_SESSION['auth'])) {

    header("Location: dashboard");
    exit();
}
else {

    header("Location: login");
    exit();
}
?>