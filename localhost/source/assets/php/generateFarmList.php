<?php

	include('dbconnect.php');
	$company_id = $_POST['company_id'];

	$sqlFarm = "SELECT * FROM tb_farm WHERE farm_company_id = '$company_id'";
	$resultFarm = mysqli_query($con,$sqlFarm);

	$farmArr = array();

	while($rowFarm = mysqli_fetch_assoc($resultFarm)){

		$newFarmObj = new \stdClass();

		$newFarmObj->farm_id = $rowFarm['farm_id'];
		$newFarmObj->farm_address = $rowFarm['farm_address'];
		$newFarmObj->farm_joinDt = $rowFarm['farm_joinDt'];
		$newFarmObj->farm_company_id = $rowFarm['farm_company_id'];
		$newFarmObj->farm_cat = $rowFarm['farm_cat'];
		$newFarmObj->farm_name = $rowFarm['farm_name'];

		array_push($farmArr, $newFarmObj);
	}

	echo  json_encode($farmArr);
	mysqli_close($con);

?>