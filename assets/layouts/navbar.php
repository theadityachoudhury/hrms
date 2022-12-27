<?php
require 'header.php';
// Navbar Starts Here
?>
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
  <a class="navbar-brand" href="<?php echo APP_LINK?>"><?php echo APP_NAME ?></a> 

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <?php if(!isset($_SESSION['auth'])){?>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo APP_LINK?>/contact">Get In Touch</a>
        </li>
      </ul>

    <?php } else{ ?>

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo APP_LINK?>/dashboard">Dashboard</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Users
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo APP_LINK?>/users">Manage Users</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_LINK?>/register">Register User</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Departments
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo APP_LINK?>/departments">Manage Departments</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_LINK?>/departments/add">Add Departments</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Profile Section
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?php echo APP_LINK?>/profile-edit">Profile Edit</a></li>
            <li><a class="dropdown-item" href="<?php echo APP_LINK?>/logout">Logout</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?php echo APP_LINK?>/contact">Get In Touch</a></li>
          </ul>
        </li>
      </ul>


    <?php } ?>














      
      
    </div>
  </div>
</nav>