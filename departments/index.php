<?php
define('TITLE', 'Departments');
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
?>


<div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Employee Details
                            <a href="../departments/add" class="btn btn-primary float-end">Add Departments</a>
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
                                    <th>Department ID</th>
                                    <th>Department Name</th>
                                    <th>No. Of Employees</th>
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
                                        $sql = "SELECT * FROM department WHERE concat(id,dep_name) LIKE '%$value_filter%'";
                                    }
                                    else{
                                    $sql = 'SELECT * FROM department';
                                    }
                                }
                                $results = mysqli_query($conn,$sql);

                                    if(mysqli_num_rows($results) > 0)
                                    {
                                        foreach($results as $department){?>
                                            <tr>
                                                <td><?= $department['id']; ?></td>
                                                <td><?= $department['dep_name']; ?></td>
                                                <td><?= $department['count']; ?></td>
                                                <td>
                                                    <a href="view.php?id=<?= $department['id']; ?>" class="btn btn-info btn-sm">View</a>
                                                    <form action="delete.php" method="POST" class="d-inline">
                                                    <button type="submit" name="delete_student" value="<?=$department['id'];?>" class="btn btn-danger btn-sm">Delete</button>
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
