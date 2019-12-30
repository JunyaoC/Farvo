<?php
	
	require('dbconnect.php');

	$batch_uid  = $_POST['batch_uid'];
	$batch_status  = $_POST['batch_status'];

	$sql = "UPDATE tb_batch SET batch_status = '$batch_status',batch_end_date = curdate() WHERE batch_uid = '$batch_uid'";
	$result = mysqli_query($con,$sql) or die(mysqli_error($con)) ;

	
	mysqli_close($con);



?>