<?php

	include('dbconnect.php');
	$farm_id = $_POST['farm_id'];

	$sqlHouse = "SELECT * FROM tb_house WHERE house_farm_id = '$farm_id'";
	$resultHouse = mysqli_query($con,$sqlHouse) or die(mysqli_error($con));

	$houseArr = array();

	while($rowHouse = mysqli_fetch_assoc($resultHouse)){

		$newHouseObj = new \stdClass();

		$newHouseObj->house_id = $rowHouse['house_id'];
		$newHouseObj->house_capacity = $rowHouse['house_capacity'];
		$newHouseObj->house_cat = $rowHouse['house_cat'];
		$newHouseObj->house_farm_id = $rowHouse['house_farm_id'];
		$newHouseObj->house_status = $rowHouse['house_status'];
		$newHouseObj->house_used_capacity = $rowHouse['house_used_capacity'];
		$newHouseObj->house_name = $rowHouse['house_name'];


		array_push($houseArr, $newHouseObj);
	}

	echo  json_encode($houseArr);
	mysqli_close($con);

?>
