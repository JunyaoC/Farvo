<?php

	require('dbconnect.php');

	$op = $_POST["op"];
	$compId = $_POST['compId'];
	$userId= $_POST['userId'];
	$level= $_POST['level'];

	if($op == 'edit'){

		$sql = "UPDATE tb_access
				SET access_level = '$level'
				WHERE access_company_id = '$compId' AND access_user_id = '$userId'";

		mysqli_query($con,$sql);
		

	}

	if($op == 'remove'){

		$sql = "DELETE FROM tb_access
				WHERE access_company_id = '$compId' AND access_user_id = '$userId'";

		mysqli_query($con,$sql);
		

	}



?>