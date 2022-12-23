<?php
define('TITLE', "Tasks");
include '../assets/layouts/navbar.php';
check_verified();
if($_SESSION['level']==2){
    header("Location: ../");
}
?>




<div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Employee Details
                            <a href="../register" class="btn btn-primary float-end">Add Users</a>
                        </h4>
                    </div>
                    <div class="card-body">

                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="filter_value" class="form-control" placeholder="Search" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" name="filter_btn" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </form>

                    </div>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>E-Mail</th>
                                    <th>Level</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if($_SESSION['level']==0){
                                    if(isset($_POST['filter_btn'])){
                                        foreach($_POST as $key => $value){
                                            $_POST[$key] = _cleaninjections(trim($value));
                                        }
                                        $value_filter = $_POST['filter_value'];
                                        $sql = "SELECT * FROM users WHERE concat(id,username,email,first_name,last_name) LIKE '%$value_filter%'";
                                    }
                                    else{
                                    $sql = 'SELECT * FROM users';
                                    }
                                }
                                else{
                                    if(isset($_POST['filter_btn'])){
                                        $value_filter = $_POST['filter_value'];
                                        $department = $_SESSION['department'];
                                        $sql = "SELECT * FROM users WHERE department='$department' && concat(id,username,email,first_name,last_name) LIKE '%$value_filter%'";
                                    }else{
                                        $sql = "SELECT * FROM users WHERE department='$department';";
                                    }
                                }
                                $results = mysqli_query($conn,$sql);

                                    if(mysqli_num_rows($results) > 0)
                                    {
                                        foreach($results as $employee)
                                        {
                                            $name = $employee['first_name']." ".$employee['last_name'];
                                            ?>
                                            <tr>
                                                <td><?= $employee['username']; ?></td>
                                                <td><?= $name; ?></td>
                                                <td><?= $employee['email']; ?></td>
                                                <?php if($employee['level']==0){?>
                                                    <td>Super Admin</td>
                                                <?php } else if($employee['level']==1){?>
                                                    <td>Admin/HOD</td>
                                                <?php } else{?>
                                                    <td>Employee</td>
                                                <?php }?>
                                                <td><?= $employee['department']; ?></td>
                                                <?php if(!isset($employee['deleted_at'])){ ?>
                                                    <?php if(!isset($employee['verified_at'])){ ?>
                                                        <td>Not Verified</td>
                                                    <?php }else{?>
                                                        <td>Verified</td>
                                                    <?php }}else{?>
                                                        <td>User Deleted</td>
                                                <?php }?>
                                                <td>
                                                <?php if($employee['id']!=$_SESSION['id']){?>
                                                    <a href="view.php?id=<?= $employee['id']; ?>" class="btn btn-info btn-sm">View</a>
                                                <?php } else{?>
                                                    <a href="../profile-edit" class="btn btn-info btn-sm">View</a>
                                                <?php } ?>
                                                    <form action="delete.php" method="POST" class="d-inline">
                                                    <?php if($employee['id']!=$_SESSION['id'] && !isset($employee['deleted_at'])){?>
                                                        <button type="submit" name="delete_student" value="<?=$employee['id'];?>" class="btn btn-danger btn-sm">Delete</button>
                                                    <?php } else{?>
                                                        <button type="submit" name="delete_student" value="<?=$employee['id'];?>" class="btn btn-danger btn-sm" disabled>Delete</button>
                                                    <?php } ?>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        echo "<h5> No Record Found </h5>";
                                    }
                                ?>
                                
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include '../assets/layouts/footer.php'; ?>