<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin'])=="") {
    header("Location: index.php");
} else {
    if (isset($_POST['update'])) {
        $classname=$_POST['classname'];
        $year=$_POST['year'];
        $dept=$_POST['dept'];
        $cid=intval($_GET['classid']);
        $sql="update classes set classname=:classname,year=:year,dept=:dept where id=:cid ";
        $query = $dbh->prepare($sql);
        $query->bindParam(':classname', $classname, PDO::PARAM_STR);
        $query->bindParam(':year', $year, PDO::PARAM_STR);
        $query->bindParam(':dept', $dept, PDO::PARAM_STR);
        $query->bindParam(':cid', $cid, PDO::PARAM_STR);
        $query->execute();
        $msg="Data has been updated successfully";
    } ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS Admin Update Class</title>
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
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
                                <h2 class="title">Update Student Class</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a>
                                    </li>
                                    <li><a href="manage-classes.php">Manage Classes</a>
                                    </li>
                                    <li class="active">Update Class</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <h5>Update Student Class info</h5>
                                            </div>
                                        </div>
                                        <?php if ($msg) {?>
                                        <div class="alert alert-success left-icon-alert" role="alert">
                                            <?php echo htmlentities($msg); ?>
                                        </div>
                                        <?php } elseif ($error) {?>
                                        <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Error!</strong>
                                            <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                        <form method="post">
                                            <?php
                                            $cid=intval($_GET[ 'classid']);
                                            $sql="SELECT * from classes inner join departments on classes.dept=departments.id where classes.id=:cid" ;
                                            $query=$dbh->prepare($sql);
                                            $query->bindParam(':cid', $cid, PDO::PARAM_STR);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt=1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) { ?>
                                            <div class="form-group has-success">
                                                <label for="success" class="control-label">Class Name</label>
                                                <div class="">
                                                    <input type="text" name="classname"
                                                        value="<?php echo htmlentities($result->classname); ?>"
                                                        required="required" class="form-control" id="success">
                                                </div>
                                            </div>
                                            <div class="form-group has-success">
                                                <label for="success" class="control-label">Year</label>
                                                <div class="">
                                                    <input type="number" name="year"
                                                        value="<?php echo htmlentities($result->year); ?>"
                                                        required="required" class="form-control" id="success">
                                                </div>
                                            </div>

                                            <div class="form-group has-success">
                                                <label for="default" class="control-label">Department</label>
                                                <div class="control-label">
                                                    <select name="dept" class="form-control" id="default"
                                                        required="required">
                                                        <option value="<?php echo htmlentities($result->dept); ?>">
                                                            <?php echo htmlentities($result->name);?></option>
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

                                            <?php }
    } ?>
                                            <div class="form-group has-success">
                                                <div class="">
                                                    <button type="submit" name="update"
                                                        class="btn btn-success btn-labeled">Update<span
                                                            class="btn-label btn-label-right"><i
                                                                class="fa fa-check"></i></span>
                                                    </button>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </section>
            </div>
        </div>
    </div>
    </div>
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/jquery-ui/jquery-ui.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>
    <script src="js/prism/prism.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
<?php
} ?>