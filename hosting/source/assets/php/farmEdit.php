<?php

	require('dbconnect.php');

	$farm_name = $_POST["edit_farm_name"];
	$farm_address = $_POST["edit_farm_address"];
	$farm_cat = $_POST["edit_farm_cat"];
	$farm_id = $_POST["edit_farm_id"];


	$sql = "UPDATE tb_farm SET farm_name = '$farm_name', farm_address = '$farm_address', farm_cat = '$farm_cat'
			WHERE farm_id = '$farm_id'";

	mysqli_query($con,$sql);
	mysqli_close($con);

?>
