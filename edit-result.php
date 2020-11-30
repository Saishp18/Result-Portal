<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin'])=="") {
    header("Location: index.php");
} else {
    $sql = "SELECT distinct(m.flag) as resultstatus,CT.id as ctid  FROM COURSETEACHER AS CT INNER JOIN CLASSES AS CLS ON CT.class=CLS.ID JOIN marks as m on m.ct=CT.id where CLS.id=:classid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':classid', $_GET['classid'], PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    $ctid=$results[0]->ctid;
    // echo ($results[0]->resultstatus);
    if($results[0]->resultstatus == '0' || !$results[0]->resultstatus)
        $resultstatus="Hidden";
    else
        $resultstatus="Visible";



    if (isset($_POST['resultdeclare'])) {
        # Publish-button was clicked
        $sql="UPDATE marks m inner join courseteacher ct on ct.id=m.ct inner join classes c on c.id=ct.class SET m.flag=1 where c.id=:classid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':classid', $_GET['classid'], PDO::PARAM_STR);
        $query->execute();
 
    } elseif (isset($_POST['resulthide'])) {
        # Save-button was clicked
        $sql="UPDATE marks m inner join courseteacher ct on ct.id=m.ct inner join classes c on c.id=ct.class SET m.flag=0 where c.id=:classid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':classid', $_GET['classid'], PDO::PARAM_STR);
        $query->execute();
    }

    $sql = "SELECT * from classes where id=:id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $_GET['classid'], PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    $classname=$results[0]->classname;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Manage Results</title>
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
                            <div class="col-md-6">
                                <h2 class="title">Manage Results for
                                    <?php
                                    echo htmlentities($classname);
                                    ?>
                                </h2>

                            </div>

                            <!-- /.col-md-6 text-right -->
                        </div>
                        <!-- /.row -->
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li class="active"><a href="manage-results.php">Manage Results</a> </li>
                                    <li class="active"><a href="#">Class Results</a> </li>

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
                                        <table>
                                            <tr>
                                                <form class="form-horizontal" method="post">
                                                    <td>
                                                        <input type="submit" class="btn btn-primary"
                                                            name=" resultdeclare" value="Show Result" />
                                                    </td>
                                                    <td>
                                                        <input type="submit" class="btn btn-primary" name="resulthide"
                                                            value="Hide Result" />
                                                    </td>

                                                    <?php if($resultstatus=='Hidden'){?>
                                                    <td class="float-right bg-danger">
                                                        <label for="default" class="control-label">
                                                            Result status:
                                                            <?php
                                                                echo htmlentities($resultstatus);
                                                            ?>
                                                        </label>
                                                    </td>
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php if ($resultstatus=='Visible') {?>
                                                    <td class="float-right bg-success ">
                                                        <label for="default" class="control-label">
                                                            Result status:
                                                            <?php
                                                                echo htmlentities($resultstatus);
                                                            ?>
                                                        </label>
                                                    </td>
                                                    <?php
                                                    }
                                                    ?>

                                                </form>
                                            </tr>
                                        </table>
                                        <div class="panel-body p-20">

                                            <table id="example" class="display table table-striped table-bordered"
                                                cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Course</th>
                                                        <th>Teacher</th>
                                                        <th>Total Students</th>
                                                        <th>Total Marks entered</th>
                                                        <!-- <th>Edit</th> -->
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Course</th>
                                                        <th>Teacher</th>
                                                        <th>Total Students</th>
                                                        <th>Total Marks entered</th>
                                                        <!-- <th>Edit</th> -->
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php 
                                                    $sql = "SELECT ct.id as id, d.code as department, cls.classname as class, cls.id as classid, c.name as coursename, c.code as coursecode, t.name as teacher  FROM COURSETEACHER AS CT INNER JOIN COURSES AS C ON CT.course=C.id INNER JOIN CLASSES AS CLS ON CT.class=CLS.ID INNER JOIN Teachers as T ON CT.teacher=T.ID INNER JOIN DEPARTMENTS AS D ON D.ID=cls.DEPT where CLS.id=:classid";
                                                    $query = $dbh->prepare($sql);
                                                    $query->bindParam(':classid', $_GET['classid'], PDO::PARAM_STR);
                                                    $query->execute();
                                                    $results=$query->fetchAll(PDO::FETCH_OBJ);

                                                    
                                                    $cnt=1;
                                                    if ($query->rowCount() > 0) {
                                                        foreach ($results as $result) {   
                                                            $sql1="SELECT count(id) as countstudents from students where class=:classid" ;
                                                            $query1= $dbh->prepare($sql1);
                                                            $query1->bindParam(':classid', $_GET['classid'], PDO::PARAM_STR);
                                                            $query1->execute();
                                                            $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                                                            // echo $result->id;
                                                            $sql2="SELECT count(id) as countmarks from marks where ct=:ctid" ;
                                                            $query2= $dbh->prepare($sql2);
                                                            $query2->bindParam(':ctid', $result->id, PDO::PARAM_STR);
                                                            $query2->execute();
                                                            $results2=$query2->fetchAll(PDO::FETCH_OBJ);


                                                    ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($cnt); ?></td>
                                                        <td><?php echo htmlentities($result->coursename); ?>
                                                        </td>
                                                        <td><?php echo htmlentities($result->teacher); ?></td>
                                                        <td><?php echo htmlentities($results1[0]->countstudents); ?>
                                                        </td>
                                                        <td><?php echo htmlentities($results2[0]->countmarks); ?>
                                                        </td>
                                                        <td>
                                                            <a href="view-course-results.php?ctid=
                                                                <?php
                                                                 echo htmlentities($result->id); 
                                                                ?>">
                                                                <i class="fa fa-eye" title="View Records"></i>
                                                            </a>
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
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>
    <script src="js/prism/prism.js"></script>
    <script src="js/DataTables/datatables.min.js"></script>
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
</body>

</html>
<?php
} ?>