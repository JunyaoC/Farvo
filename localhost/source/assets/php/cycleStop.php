<?php
	
	require('dbconnect.php');

	$cycle_id  = $_POST['cycle_id'];
	$cycle_status  = $_POST['cycle_status'];

	$sql = "UPDATE tb_cycle SET cycle_status = '$cycle_status',cycle_end_date = curdate() WHERE cycle_id = '$cycle_id'";
	$result = mysqli_query($con,$sql) or die(mysqli_error($con)) ;

	
	mysqli_close($con);



?>