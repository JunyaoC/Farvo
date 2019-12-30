<?php
	
	require('dbconnect.php');

	$cost_date  = $_POST['cost_date'];
	$cost_category  = $_POST['cost_category'];
	$cost_amount  = $_POST['cost_amount'];
	$cost_note  = $_POST['cost_note'];
	$cost_cycle_id  = $_POST['cost_cycle_id'];

	$sql = "INSERT INTO tb_cost(cost_date,cost_category,cost_amount,cost_note,cost_cycle_id)
			VALUES('$cost_date','$cost_category','$cost_amount','$cost_note','$cost_cycle_id')";
	$result = mysqli_query($con,$sql);
	mysqli_close($con);

?>