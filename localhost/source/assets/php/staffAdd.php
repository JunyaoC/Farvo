<?php

	require('dbconnect.php');

	$user_id = $_POST["add_user_id"];
	$company_id = $_POST["add_company_id"];
	$access_level = $_POST["add_access_level"];

	echo $user_id;

	$sqlTest = "SELECT * FROM tb_access WHERE access_company_id = '$company_id' AND access_user_id = '$user_id'";

	$resultTest = mysqli_query($con,$sqlTest) or die(mysqli_error($con));

	if(mysqli_num_rows($resultTest) > 0 ){
		echo "userexist";
	} else{
		$sql = "INSERT INTO tb_access(access_company_id,access_user_id,access_level)
				VALUES('$company_id','$user_id','$access_level')";

		mysqli_query($con,$sql);	
	}

?>