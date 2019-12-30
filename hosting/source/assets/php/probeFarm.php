<?php

	require('dbconnect.php');
	
	$user_id = $_POST['user_id'];

	$sql = "SELECT * FROM tb_farm_access WHERE fa_user_id = '$user_id'";
	$result = mysqli_query($con,$sql);

	$allowedFarmList = array();

	while($row = mysqli_fetch_assoc($result)){

		$farm_id = $row['fa_farm_id'];
		array_push($allowedFarmList, $farm_id);

	};

	echo json_encode($allowedFarmList);


?>