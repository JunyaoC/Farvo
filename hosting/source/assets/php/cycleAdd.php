<?php

	require('dbconnect.php');

	$cycle_farm_id = $_POST['cycle_farm_id'];
	$cycle_init_date = $_POST['cycle_init_date'];
	$cycle_name = $_POST['cycle_name'];

	$sqlCode = "SELECT * FROM tb_category WHERE category_desc = 'active' AND category_level = 'cycle_status'";
    $resultCode = mysqli_query($con,$sqlCode);
    $rowCode = mysqli_fetch_assoc($resultCode);
    $cycleStatusActive = $rowCode['category_id'];

	$sql = "INSERT INTO tb_cycle(cycle_farm_id,cycle_init_date,cycle_name,cycle_status)
				VALUES('$cycle_farm_id','$cycle_init_date','$cycle_name','$cycleStatusActive')";
	mysqli_query($con,$sql);
	mysqli_close($con);
?>
