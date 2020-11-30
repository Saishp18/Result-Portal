<?php
session_start();
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Result Portal</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen"> <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
    <style>
    .login-form {
        width: 340px;
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
    <div class="main-wrapper">
        <div class="">
            <div class="row">
                <h1 align="center">Student Result Management System</h1>
                <div class="login-form">
                    <h2 class="text-center">Select user type</h2>
                    <div class="form-group ">
                        <button name="student" onclick="location.href='student-result.php'"
                            class="btn btn-primary btn-block bg-success">Student</button>
                    </div>
                    <div class="form-group ">
                        <button name="teacher" onclick="location.href='teacher-login.php'"
                            class="btn btn-primary btn-block bg-danger">Teacher</button>
                    </div>
                    <div class="form-group">
                        <button name="admin" onclick="location.href='admin-login.php'"
                            class="btn btn-primary btn-block bg-warning">Admin</button>
                    </div>
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