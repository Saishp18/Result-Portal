<html>

<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <?php 
include_once("db_connect.php");
?> <title>phpzag.com : Demo Inline Editing using PHP MySQL and jQuery Ajax</title>
    <script type="text/javascript" src="script/functions.js"></script>
</head>

<body>
    <div class="container">
        <h2>Example: Inline Editing using PHP MySQL and jQuery ajax</h2>
        <?php
	$sql = "SELECT id, name, email, gender FROM students";
	$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
	?>
        <table class="table table-condensed table-hover table-striped bootgrid-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                </tr>
            </thead>
            <tbody>
                <?php
		 while( $rows = mysqli_fetch_assoc($resultset) ) { 
		 ?>
                <tr>
                    <td contenteditable="true" data-old_value="<?php echo $rows["name"]; ?>"
                        onBlur="saveInlineEdit(this,'name','<?php echo $rows["id"]; ?>')"
                        onClick="highlightEdit(this);">
                        <?php echo $rows["name"]; ?></td>
                    <td contenteditable="true" data-old_value="<?php echo $rows["email"]; ?>"
                        onBlur="saveInlineEdit(this,'email','<?php echo $rows["id"]; ?>')"
                        onClick="highlightEdit(this);">
                        <?php echo $rows["email"]; ?></td>
                    <td contenteditable="true" data-old_value="<?php echo $rows["gender"]; ?>"
                        onBlur="saveInlineEdit(this,'gender','<?php echo $rows["id"]; ?>')"
                        onClick="highlightEdit(this);">
                        <?php echo $rows["gender"]; ?></td>
                </tr>
                <?php
		}
		?>
            </tbody>
        </table>
    </div>

</body>

</html>