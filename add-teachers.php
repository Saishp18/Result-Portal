<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin'])=="") {
    header("Location: index.php");
} else {
    if (isset($_POST['submit'])) {
        $name=$_POST['name'];
        $email=$_POST['email'];
        $password=md5($_POST['password']);
        $dept=$_POST['dept'];
        $sql="INSERT INTO teachers(name, email, password, dept) VALUES(:name,:email,:password,:dept)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':dept', $dept, PDO::PARAM_INT);
        
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            $msg="Teacher's info added.";
        } else {
            $error="Please try again.";
        }
    } ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS Admin| Teacher Registration< </title>
            <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
            <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
            <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
            <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
            <link rel="stylesheet" href="css/prism/prism.css" media="screen">
            <link rel="stylesheet" href="css/select2/select2.min.css">
            <link rel="stylesheet" href="css/main.css" media="screen">
            <script src="js/modernizr/modernizr.min.js"></script>
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <?php include('includes/topbar.php'); ?>
        <div class="content-wrapper">
            <div class="content-container">
                <?php include('includes/leftbar.php'); ?>
                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Teacher Registration</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a>
                                    </li>
                                    <li class="active">Teacher Registration</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h5>Fill teacher's details</h5>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <?php if ($msg) {?>
                                        <div class="alert alert-success left-icon-alert" role="alert">
                                            <strong>Successful!</strong>
                                            <?php echo htmlentities($msg); ?>
                                        </div>
                                        <?php } elseif ($error) {?>
                                        <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Error!</strong>
                                            <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                        <form class="form-horizontal" method="post">
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Full Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="name" class="form-control" id="name"
                                                        required="required" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Email id</label>
                                                <div class="col-sm-10">
                                                    <input type="email" name="email" class="form-control" id="email"
                                                        required="required" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Password</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="password" class="form-control"
                                                        id="password" placeholder="default password"
                                                        required=" required" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Department</label>
                                                <div class="col-sm-10">
                                                    <select name="dept" class="form-control" id="dept"
                                                        required="required">
                                                        <option value="">Select Department</option>
                                                        <?php $sql = "SELECT * from departments";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) {   ?>
                                                        <option value="<?php echo htmlentities($result->id); ?>">
                                                            <?php echo htmlentities($result->name);?>&nbsp;
                                                        </option>
                                                        <?php }
                                                            } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" name="submit"
                                                        class="btn btn-primary">Add</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script src="js/select2/select2.min.js"></script>
        <script src="js/main.js"></script>
        <script>
        $(function($) {
            $(".js-states").select2();
            $(".js-states-limit").select2({
                maximumSelectionLength: 2
            });
            $(".js-states-hide").select2({
                minimumResultsForSearch: Infinity
            });
        });
        </script>
</body>

</html>
<?php
} ?>