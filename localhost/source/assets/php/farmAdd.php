<?php

	require('dbconnect.php');

	$farm_company_id = $_POST['farm_company_id'];
	$farm_name = $_POST['farm_name'];
	$farm_cat = $_POST['farm_cat'];
	$farm_address = $_POST['farm_address'];


	// echo $farm_company_id.' '.$farm_name.' '.$farm_cat.' '.$farm_address;

	$sql = "INSERT INTO tb_farm(farm_company_id,farm_name,farm_cat,farm_address,farm_joinDt)
				VALUES('$farm_company_id','$farm_name','$farm_cat','$farm_address',now())";
	mysqli_query($con,$sql);
	mysqli_close($con);
?>
