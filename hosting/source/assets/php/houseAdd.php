<?php

	require('dbconnect.php');

	$house_name = $_POST["house_name"];
	$house_capacity = $_POST["house_capacity"];
	$house_cat = $_POST["house_cat"];
	$house_farm_id = $_POST["house_farm_id"];
	$house_status = $_POST["house_status"];

	$sql = "INSERT INTO tb_house(house_name,house_capacity,house_cat,house_farm_id,house_status,house_used_capacity)
			VALUES('$house_name','$house_capacity','$house_cat','$house_farm_id','$house_status','0')";

	mysqli_query($con,$sql);
	mysqli_close($con);
?>