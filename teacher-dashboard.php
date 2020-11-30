<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['tlogin'])=="") {
    header("Location: index.php");
} else {
    $sql1 ="SELECT * from teachers where email=:email";
    $query1 = $dbh -> prepare($sql1);
    $query1-> bindParam(':email', $_SESSION['tlogin'], PDO::PARAM_STR);
    $query1->execute();
    $results1=$query1->fetchAll(PDO::FETCH_OBJ);
    $name = $results1[0]->name;
    $teacherid = $results1[0]->id;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teacher | Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/toastr/toastr.min.css" media="screen">
    <link rel="stylesheet" href="css/icheck/skins/line/blue.css">
    <link rel="stylesheet" href="css/icheck/skins/line/red.css">
    <link rel="stylesheet" href="css/icheck/skins/line/green.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">
        <?php include('includes/teacher-topbar.php'); ?>
        <div class="content-wrapper">
            <div class="content-container">

                <?php include('includes/teacher-leftbar.php'); ?>

                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-sm-6">
                                <h2 class="title">
                                    <?php echo htmlentities($name); ?>'s Dashboard </h2>

                            </div>
                            <!-- /.col-sm-6 -->
                        </div>
                        <!-- /.row -->

                    </div>
                    <!-- /.container-fluid -->

                    <section class="section">
                        <div class="container-fluid">
                            <div class="row">

                                <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->

                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat bg-warning" href="teacher-classes.php">
                                        <?php
                                        $sql2 ="SELECT  distinct class from  courseteacher where teacher=:teacherid ";
                                        $query2 = $dbh -> prepare($sql2);
                                        $query2-> bindParam(':teacherid', $teacherid, PDO::PARAM_STR);
                                        $query2->execute();
                                        $results2=$query2->fetchAll(PDO::FETCH_OBJ);
                                        $totalclasses=$query2->rowCount(); ?>
                                        <span class="number "><?php echo htmlentities($totalclasses); ?></span>
                                        <span class="name">Classes</span>
                                        <span class="bg-icon"><i class="fa fa-users"></i></span>
                                    </a>
                                    <!-- /.dashboard-stat -->
                                </div>
                                <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->

                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <a class="dashboard-stat bg-success" href="teacher-classes.php">
                                        <?php
                                        $sql3="SELECT  distinct course from  courseteacher where teacher=:teacherid ";

                                            $query3 = $dbh -> prepare($sql3);
                                            $query3-> bindParam(':teacherid', $teacherid, PDO::PARAM_STR);
                                            $query3->execute();
                                            $results3=$query3->fetchAll(PDO::FETCH_OBJ);
                                            $totalresults=$query3->rowCount(); ?>

                                        <span class="number "><?php echo htmlentities($totalresults); ?></span>
                                        <span class="name">Courses</span>
                                        <span class="bg-icon"><i class="fa fa-book"></i></span>
                                    </a>
                                    <!-- /.dashboard-stat -->
                                </div>
                                <!-- <div class="row mt-ml-5"> -->


                                <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->
                            </div>
                        </div>
                        <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
                </section>
                <!-- /.section -->

            </div>
            <!-- /.main-page -->


        </div>
        <!-- /.content-container -->
    </div>
    <!-- /.content-wrapper -->

    </div>
    <!-- /.main-wrapper -->

    <!-- ========== COMMON JS FILES ========== -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/jquery-ui/jquery-ui.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>
    <script src="js/waypoint/waypoints.min.js"></script>
    <script src="js/counterUp/jquery.counterup.min.js"></script>
    <script src="js/amcharts/amcharts.js"></script>
    <script src="js/amcharts/serial.js"></script>
    <script src="js/amcharts/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="js/amcharts/plugins/export/export.css" type="text/css" media="all" />
    <script src="js/amcharts/themes/light.js"></script>
    <script src="js/toastr/toastr.min.js"></script>
    <script src="js/icheck/icheck.min.js"></script>

    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>
    <script src="js/production-chart.js"></script>
    <script src="js/traffic-chart.js"></script>
    <script src="js/task-list.js"></script>

</body>

</html>
<?php
} ?>