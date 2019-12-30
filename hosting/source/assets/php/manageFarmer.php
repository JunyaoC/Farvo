<?php
	
	require('dbconnect.php');

	$user_id = $_POST['user_id'];
	$operation = $_POST['operation'];
	$farm_id = $_POST['farm_id'];

	switch ($operation) {
		case 'allow':
			$sqlFarmerAccess = "INSERT tb_farm_access(fa_user_id,fa_farm_id) VALUES('$user_id','$farm_id')";
			$resultFarmerAccess = mysqli_query($con,$sqlFarmerAccess);
			break;

		case 'disallow':
			$sqlFarmerAccess = "DELETE FROM tb_farm_access WHERE fa_user_id = '$user_id' AND fa_farm_id = '$farm_id'";
			$resultFarmerAccess = mysqli_query($con,$sqlFarmerAccess);
			break;
	}
	mysqli_close($con);
?>