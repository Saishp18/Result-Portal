<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (isset($_POST['submit'])) {
    $rollno=$_POST['rollno'];
    $email=$_POST['email'];
    $class=$_POST['class'];
    $sql ="SELECT rollno, email, class FROM students WHERE rollno=:rollno and email=:email and class=:class";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':rollno', $rollno, PDO::PARAM_STR);
    $query-> bindParam(':email', $email, PDO::PARAM_STR);
    $query-> bindParam(':class', $class, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        $_SESSION['rollno']=$_POST['rollno'];
        $_SESSION['email']=$_POST['email'];
        $_SESSION['class']=$_POST['class'];
        echo "<script type='text/javascript'> document.location = 'result.php'; </script>";
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Result</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>

    <style>
    .login-form {
        width: 380px;
        margin: 50px auto;
        font-size: 15px;
    }

    .login-form form {
        margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }

    .login-form h2 {
        margin: 0 0 15px;
    }

    .form-control,
    .btn {
        min-height: 38px;
        border-radius: 2px;
    }

    .btn {
        font-size: 15px;
        font-weight: bold;
    }
    </style>
</head>

<body class="">
    <h1 align="center">Student Result Management System</h1>

    <div class="login-form">
        <form method="post">
            <h2 class="text-center">Student: View Result</h2>
            <div class="form-group">
                <input type="number" name="rollno" class="form-control" placeholder="Roll No" required="required">
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" required="required">
            </div>
            <div class="form-group">
                <select name="class" class="form-control" id="default" required="required">
                    <option value="">Select Class </option>
                    <?php $sql = "SELECT c.id as id, d.code as deptcode, c.year as year, c.classname as classname from classes as c join departments as d on c.dept=d.id";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) {   ?>
                    <option value=" <?php echo htmlentities($result->id); ?>">
                        <?php echo htmlentities($result->deptcode)?>
                        &nbsp; &nbsp;(
                        <?php echo htmlentities($result->classname)?>
                        )
                    </option>
                    <?php }
                                                        } ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-primary btn-block">Submit</button>
            </div>
            <div class="clearfix">
                <a href="index.php" class="float-right">Back</a>
            </div>
        </form>
    </div>
    <!-- ========== COMMON JS FILES ========== -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/jquery-ui/jquery-ui.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/pace/pace.min.js"></script>
    <script src="js/lobipanel/lobipanel.min.js"></script>
    <script src="js/iscroll/iscroll.js"></script>

    <!-- ========== PAGE JS FILES ========== -->

    <!-- ========== THEME JS ========== -->
    <script src="js/main.js"></script>
    <script>
    $(function() {

    });
    </script>

    <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
</body>

</html>