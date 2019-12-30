<?php

	require('dbconnect.php');

	$house_name = $_POST["house_name"];
	$house_capacity = $_POST["house_capacity"];
	$house_cat = $_POST["house_cat"];
	$house_status = $_POST["house_status"];
	$house_id = $_POST["house_id"];
	$house_company = $_POST["house_company_id"];

	$sql = "UPDATE tb_house SET house_name = '$house_name', house_capacity = '$house_capacity', house_cat = '$house_cat', house_status = '$house_status'
			WHERE house_id = '$house_id'";

	mysqli_query($con,$sql);
	mysql_close($con);
?>