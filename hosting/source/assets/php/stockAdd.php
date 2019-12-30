<?php

	require('dbconnect.php');

	$stock_name = $_POST["stock_name"];
	$stock_farm_id = $_POST["stock_farm_id"];

	$sql = "INSERT INTO tb_stock(stock_name,stock_farm_id)
			VALUES('$stock_name','$stock_farm_id')";

	mysqli_query($con,$sql);
	mysqli_close($con);
?>