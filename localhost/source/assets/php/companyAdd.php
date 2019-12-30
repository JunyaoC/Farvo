<?php
	
	session_start();
	
	require('dbconnect.php');


	$company_name = $_POST['company_name'];
	$company_address = $_POST['company_address'];
	$company_ssm = $_POST['company_ssm'];
	$company_cat = $_POST['company_cat'];
	$add_user_id = $_POST['add_user_id'];

	$sql = "SELECT *
			FROM tb_company
			WHERE company_name = '$company_name' AND company_ssm = '$company_ssm'";

	$result = mysqli_query($con,$sql);

	var_dump(mysqli_fetch_assoc($result));

	if(mysqli_num_rows($result) > 0){
		//header('Location: ../manageCompany.php?state=1'); /// here return 1 in GET such that the company already exists
		echo "Company Existed!";
	} else{
		$sql = "INSERT INTO tb_company(company_name,company_address,company_ssm,company_joinDt,company_cat)
				VALUES('$company_name','$company_address','$company_ssm',now(),'$company_cat')";
		
		mysqli_query($con,$sql);

		$sqlCompId = "SELECT company_id
					  FROM tb_company
					  WHERE company_ssm = '$company_ssm' AND company_name = '$company_name'";

		$resultCompId = mysqli_query($con,$sqlCompId);
		$rowCompId = mysqli_fetch_assoc($resultCompId);
		$company_id = $rowCompId['company_id'];

		$sql = "INSERT INTO tb_access(access_company_id,access_user_id,access_level)
		VALUES('$company_id','$add_user_id','4')";

		$result = mysqli_query($con,$sql) or die(mysqli_error($con));
		mysqli_close($con);

	}







?>