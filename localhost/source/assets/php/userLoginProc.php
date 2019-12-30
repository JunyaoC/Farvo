<?php

	session_start();
	if(isset($_SESSION['user_id'])){

	}else{
		header('Location:../../index.php');
	}

	require('dbconnect.php');

	$user_email = $_POST['user_email'];
	$user_password = $_POST['user_password'];
	$user_password = hash('sha256',$user_password);

	$sql = "SELECT user_id,user_name
			FROM tb_user
			WHERE user_email = '$user_email' AND user_password = '$user_password'";

	$result = mysqli_query($con,$sql);

	if(mysqli_num_rows($result) == 1){
		$arr = mysqli_fetch_assoc($result);
		session_start();
		$_SESSION["user_id"] = $arr["user_id"];
		mysqli_close($con);
		header('Location:../../company.php');
	} else{
		mysqli_close($con);
		header('Location:../../index.php');
	}


?>