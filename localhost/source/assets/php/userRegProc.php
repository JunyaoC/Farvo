<?php

	session_start();
	require('dbconnect.php');

	$user_name = $_POST["user_name"];
	$user_email = $_POST["user_email"];
	$user_address = $_POST["user_address"];
	$user_phone = $_POST["user_phone"];
	$user_password = $_POST["user_password"];

	$user_password = hash('sha256',$user_password);

	$sql = "SELECT user_id
			FROM tb_user
			WHERE user_email = '$user_email'
			";

	$result = mysqli_query($con,$sql);

	if(mysqli_num_rows($result) < 1){
		$sql = "INSERT INTO tb_user(user_name,user_email,user_address,user_phone,user_password)
		VALUES ('$user_name','$user_email','$user_address','$user_phone','$user_password')";

		if (!mysqli_query($con,$sql)){
			echo("Error description: " . mysqli_error($con));
		}
		mysqli_close($con);
		header('Location:../../index.php?code=0');	


	} else{
		mysqli_close($con);
		header('Location:../../index.php?code=1');	
	}

	








?>


