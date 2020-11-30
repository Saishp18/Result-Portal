<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin'])=="") {
    header("Location: index.php");
} else {
    if (isset($_POST['submit'])) {
        $class=$_POST['class'];
        $course=$_POST['course'];
        $teacher=$_POST['teacher'];
        
        $sql="INSERT INTO courseteacher(course, class, teacher) VALUES(:course,:class,:teacher)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':course', $course, PDO::PARAM_STR);
        $query->bindParam(':class', $class, PDO::PARAM_STR);
        $query->bindParam(':teacher', $teacher, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            $msg="Added successfully";
        } else {
            $error="Something went wrong. Please try again";
        }
    } ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Course Combination< </title>
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

        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php'); ?>
        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">

                <!-- ========== LEFT SIDEBAR ========== -->
                <?php include('includes/leftbar.php'); ?>
                <!-- /.left-sidebar -->

                <div class="main-page">

                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Add Course Combination</h2>

                            </div>

                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li> Courses</li>
                                    <li class="active">Add Course Combination</li>
                                </ul>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h5>Add Course Combination</h5>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <?php if ($msg) {?>
                                        <div class="alert alert-success left-icon-alert" role="alert">
                                            <?php echo htmlentities($msg); ?>
                                        </div><?php } elseif ($error) {?>
                                        <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Error!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                        <form class="form-horizontal" method="post">
                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Class</label>
                                                <div class="col-sm-10">
                                                    <select name="class" class="form-control" id="default"
                                                        required="required">
                                                        <option value="">Select Class</option>
                                                        <?php $sql = "SELECT c.id as id, d.code as deptcode, c.year as year, c.classname as classname from classes as c join departments as d on c.dept=d.id";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) {   ?>
                                                        <option value="<?php echo htmlentities($result->id); ?>">
                                                            <?php echo htmlentities($result->deptcode)?>
                                                            &nbsp; &nbsp;
                                                            <?php echo htmlentities($result->classname)?>
                                                        </option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Course</label>
                                                <div class="col-sm-10">
                                                    <select name="course" class="form-control" id="default"
                                                        required="required">
                                                        <option value="">Select Course</option>
                                                        <?php $sql = "SELECT c.id as id, c.code as coursecode, c.name as coursename from courses as c";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) {   ?>
                                                        <option value="<?php echo htmlentities($result->id); ?>">
                                                            <?php echo htmlentities($result->coursecode."  |  ".$result->coursename); ?>
                                                        </option>
                                                        <?php }
                                                         } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="default" class="col-sm-2 control-label">Teacher</label>
                                                <div class="col-sm-10">
                                                    <select name="teacher" class="form-control" id="default"
                                                        required="required">
                                                        <option value="">Select Teacher</option>
                                                        <?php $sql = "SELECT t.id as id, t.name as name, d.code as dept from teachers as t join departments as d on t.dept=d.id";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) {   ?>
                                                        <option value="<?php echo htmlentities($result->id); ?>">
                                                            <?php echo htmlentities($result->dept."  |  ".$result->name); ?>
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
                            <!-- /.col-md-12 -->
                        </div>
                    </div>
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.main-wrapper -->
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