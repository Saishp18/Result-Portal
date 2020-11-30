<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Result
    </title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
    $("#btnPrint").live("click", function() {
        var divContents = $("#printDiv").html();
        var printWindow = window.open('', '', 'height=400,width=800');
        printWindow.document.write('<html><head><title>Result</title>');
        printWindow.document.write('</head><body >');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    });
    </script>
</head>

<body>
    <div class="main-wrapper">
        <div class="content-wrapper">
            <div class="content-container">
                <!-- /.left-sidebar -->
                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-12">
                                <h2 class="title" align="center">Student Result
                                </h2>
                            </div>
                        </div>
                        <!-- /.row -->
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                    <section class="section" id="exampl">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <div id="printDiv">
                                                    <?php
                                                // code Student Data
                                                $rollno=$_SESSION['rollno'];
                                                $email=$_SESSION['email'];
                                                $class=$_SESSION['class'];
                                                $query = "SELECT S.name as name, s.rollno as rollno, s.id as sid, C.*, D.name as deptname FROM STUDENTS AS S JOIN CLASSES AS C ON S.CLASS=C.ID JOIN DEPARTMENTS AS D ON C.DEPT=D.ID WHERE S.rollno=:rollno and S.email=:email and S.class=:class";
                                                $stmt = $dbh->prepare($query);
                                                $stmt->bindParam(':rollno', $rollno, PDO::PARAM_STR);
                                                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                                                $stmt->bindParam(':class', $class, PDO::PARAM_STR);
                                                $stmt->execute();
                                                $resultss=$stmt->fetchAll(PDO::FETCH_OBJ);
                                                $cnt=1;
                                                if ($stmt->rowCount() > 0) {
                                                    foreach ($resultss as $row) { 
                                                         ?>
                                                    <p>
                                                        <b>Name :
                                                        </b>
                                                        <?php echo htmlentities($row->name);?>
                                                    </p>
                                                    <p>
                                                        <b>Roll No :
                                                        </b>
                                                        <?php echo htmlentities($row->rollno);?>
                                                    </p>
                                                    <p>
                                                        <b>Department:
                                                        </b>
                                                        <?php echo htmlentities($row->deptname);?>
                                                    </p>
                                                    <p>
                                                        <b>Class:
                                                        </b>
                                                        <?php echo htmlentities($row->classname);?>
                                                        -
                                                        <?php echo htmlentities($row->year);?>

                                                    </p>
                                                    <?php
                                                    } ?>
                                                    <div class="panel-body p-20">

                                                        <?php
                                                        // Code for result
                                                        $query =" Select c.name as coursename,c.code as coursecode, m.marks from marks as m join students as s on s.id=m.student JOIN courseteacher as ct on m.ct=ct.id join classes as cls on ct.class=cls.id join courses as c on ct.course=c.id where s.id=:sid and cls.id=:classid and m.flag=1";
                                                        $query= $dbh -> prepare($query);
                                                            $query->bindParam(':sid', $row->sid, PDO::PARAM_STR);
                                                            $query->bindParam(':classid', $class, PDO::PARAM_STR);
                                                            $query-> execute();
                                                            $results = $query -> fetchAll(PDO::FETCH_OBJ);
                                                            // print_r($results);
                                                            $cnt=1;
                                                            $passfail="Pass";
                                                        if ($countrow=$query->rowCount()>0) {
                                                            ?>
                                                        <table class="table table-hover table-bordered" border="1"
                                                            width="100%">
                                                            <thead>
                                                                <tr style="text-align: center">
                                                                    <th style="text-align: center">#
                                                                    </th>
                                                                    <th style="text-align: center">Course Code
                                                                    </th>
                                                                    <th style="text-align: center">Course
                                                                    </th>
                                                                    <th style="text-align: center">Marks (Out of 100)
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                    foreach ($results as $result) {
                                                    ?>
                                                                <tr>
                                                                    <th scope="row" style="text-align: center">
                                                                        <?php echo htmlentities($cnt); ?>
                                                                    </th>
                                                                    <td style="">
                                                                        <?php echo htmlentities($result->coursecode); ?>
                                                                    </td>
                                                                    <td style="">
                                                                        <?php echo htmlentities($result->coursename); ?>
                                                                    </td>
                                                                    <td style="text-align: center">
                                                                        <?php echo htmlentities($totalmarks=$result->marks); 
                                                                        if($passfail=='Fail' || $result->marks<40)
                                                                            $passfail='Fail'?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                            $totlcount+=$totalmarks;
                                                                $cnt++;
                                                            } ?>
                                                                <tr>
                                                                    <th scope="row" colspan="3"
                                                                        style="text-align: center">
                                                                        Total Marks
                                                                    </th>
                                                                    <td style="text-align: center">
                                                                        <b>
                                                                            <?php echo htmlentities($totlcount); ?>
                                                                        </b>/
                                                                        <b>
                                                                            <?php echo htmlentities($outof=($cnt-1)*100); ?>
                                                                        </b>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row" colspan="3"
                                                                        style="text-align: center">
                                                                        Percentage
                                                                    </th>
                                                                    <td style="text-align: center">
                                                                        <b>
                                                                            <?php echo  htmlentities($totlcount*(100)/$outof); ?>
                                                                            %
                                                                        </b>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row" colspan="3"
                                                                        style="text-align: center">
                                                                        Result
                                                                    </th>
                                                                    <td style="text-align: center">
                                                                        <b>
                                                                            <?php echo  htmlentities($passfail); ?>

                                                                        </b>
                                                                    </td>
                                                                </tr>
                                                    </div>
                                                    <tr>
                                                        <td colspan="4" align="center">
                                                            <button id="btnPrint" class="btn btn-primary"><i
                                                                    class=" fa fa-print fa-2x" aria-hidden="true"
                                                                    style="cursor:pointer">
                                                                </i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                        }else { ?>
                                                    <div class="alert alert-warning left-icon-alert" role="alert">
                                                        Your result is not yet declared!
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                </tbody>
                                                </table>
                                            </div>
                                            <?php

                                                } else {?>
                                            <div class="alert alert-danger left-icon-alert" role="alert">
                                                <?php
                                                    echo htmlentities("Invalid details!");
                                                    }
                                                    ?>

                                            </div>
                                            <div class="col-sm-8">
                                                <a href="index.php">Back to Home
                                                </a>
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
    <script src="js/jquery/jquery-2.2.4.min.js">
    </script>
    <script src="js/bootstrap/bootstrap.min.js">
    </script>
    <script src="js/pace/pace.min.js">
    </script>
    <script src="js/lobipanel/lobipanel.min.js">
    </script>
    <script src="js/iscroll/iscroll.js">
    </script>
    <!-- ========== PAGE JS FILES ========== -->
    <script src="js/prism/prism.js">
    </script>
    <!-- ========== THEME JS ========== -->
    <script src="js/main.js">
    </script>
    <script>
    $(function($) {});

    function CallPrint(strid) {
        var prtContent = document.getElementById("exampl");
        var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
        WinPrint.document.write(prtContent.innerHTML);
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        WinPrint.close();
    }
    </script>
    </script>
    <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
</body>

</html>