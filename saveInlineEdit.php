<?php
include('includes/config.php');

$name=$_POST['name'];
        $student=$_REQUEST['student'];
        $marks=$_REQUEST['marks'];
        $ct=$_REQUEST["ct"];
        
        $sql="INSERT INTO marks
                        (student, marks, ct)
                VALUES (:student, :marks, :ct)
                ON DUPLICATE KEY UPDATE
                marks=:marks";
        
        $query = $dbh->prepare($sql);
        $query->bindParam(':student', $student, PDO::PARAM_STR);
        $query->bindParam(':marks', $marks, PDO::PARAM_STR);
        $query->bindParam(':ct', $ct, PDO::PARAM_STR);
        $query->execute();
?>