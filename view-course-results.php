<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin'])=="") {
    header("Location: index.php");
} else {
    $sid=intval();
    $sql = "SELECT c.name,cls.classname from courses as c join courseteacher as ct on ct.course=c.id join classes as cls on ct.class=cls.id where ct.id=:id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $_GET['ctid'], PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    $coursename=$results[0]->name;
    $classname=$results[0]->classname; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Marks</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
    <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css" />
    <link rel="stylesheet" href="css/main.css" media="screen">

    <script src="js/modernizr/modernizr.min.js"></script>
    <style>
    .errorWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #dd3d36;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }

    .succWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #5cb85c;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }
    </style>
</head>

<body class="top-navbar-fixed">
    <div class="main-wrapper">

        <!-- ========== TOP NAVBAR ========== -->
        <?php include('includes/topbar.php'); ?>
        <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
        <div class="content-wrapper">
            <div class="content-container">
                <?php include('includes/leftbar.php'); ?>

                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="">
                                <h2 class="title">Students Marks for
                                    <?php echo htmlentities($classname." (".$coursename.")")?> </h2>

                            </div>

                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li><a href="manage-results.php">Manage Results</a> </li>
                                    <li class="active">View Marks</li>
                                </ul>
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->

                    <section class="section">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                            </div>
                                        </div>
                                        <?php if ($msg) {?>
                                        <div class="alert alert-success left-icon-alert" role="alert">
                                            <?php echo htmlentities($msg); ?>
                                        </div><?php } elseif ($error) {?>
                                        <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Error!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                        <div class="panel-body p-20">

                                            <table id="example" class="display table table-striped table-bordered"
                                                cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Student Rollno</th>
                                                        <th>Student Name</th>
                                                        <th>Marks (0 to 100)</th>
                                                        <th>Last Updated Date</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Student Rollno</th>
                                                        <th>Student Name</th>
                                                        <th>Marks (0 to 100)</th>
                                                        <th>Last Updated Date</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                    $sql = "SELECT s.name, s.rollno, s.id FROM students AS s join courseteacher as ct on s.class=ct.class where ct.id=:ctid";
    $query = $dbh->prepare($sql);
    $query-> bindParam(':ctid', $_GET['ctid'], PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    $cnt=1;
    if ($query->rowCount() > 0) {
        foreach ($results as $result) {   ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($cnt); ?></td>
                                                        <td><?php echo htmlentities($result->rollno); ?></td>
                                                        <td><?php echo htmlentities($result->name); ?></td>

                                                        <?php
                                                        // echo $result->id;
                                                            $sql1 = "SELECT m.marks, m.id,m.updatedate, ct.id as ctid FROM marks AS m join students as s on s.id=m.student  join courseteacher as ct on m.ct=ct.id where s.id=:studentid and ct.id=:ctid";
                                                            $query1 = $dbh->prepare($sql1);
                                                            $query1-> bindParam(':studentid', $result->id, PDO::PARAM_STR);
                                                            $query1-> bindParam(':ctid', $_GET['ctid'], PDO::PARAM_STR);
                                                            $query1->execute();
                                                            $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                                                            // print_r( $results1[0]);
                                                            ?>

                                                        <td>
                                                            <?php echo $results1[0]->marks; ?></td>

                                                        <td>
                                                            <?php echo $results1[0]->updatedate; ?></td>

                                                        </td>
                                                    </tr>
                                                    <?php $cnt=$cnt+1;
                                                        }
    } ?>


                                                </tbody>
                                            </table>


                                            <!-- /.col-md-12 -->
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col-md-6 -->


                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-md-6 -->

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
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js"></script>
    <script src="js/DataTables/datatables.min.js"></script>

    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>
    <script>
    $(function($) {
        $('#example').DataTable();

        $('#example2').DataTable({
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": false
        });

        $('#example3').DataTable();
    });
    </script>
    <script>
    function highlightEdit(editableObj) {
        $(editableObj).css("background", "#FFF");
    }

    function saveInlineEdit(editableObj, column, student, ct) { // no change change made then return false
        if ($(editableObj).attr('data-old_value') === $.trim(editableObj.innerHTML))
            return false; // send ajax to update value
        $(editableObj).css("background", "#FFF url(loader.gif) no-repeat right");

        $.ajax({
            url: "saveInlineEdit.php",
            cache: false,
            data: 'column=' + column + '&marks=' + $.trim(editableObj.innerHTML) + '&student=' + student +
                '&ct=' + ct,
            success: function(response) {

                console.log(student + " + " + ct);
                // set updated value as old value
                $(editableObj).attr('data-old_value', $.trim(editableObj.innerHTML));
                //  $(editableObj).attr('value', "Hello");
                $(editableObj).css("background", "");
            }
        });
    }
    </script>
</body>

</html>
<?php
} ?>