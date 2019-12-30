<?php

	require('dbconnect.php');

	$company_name = $_POST['edit_company_name'];
	$company_cat = $_POST['edit_company_cat'];
	$company_ssm = $_POST['edit_company_ssm'];
	$company_address = $_POST['edit_company_address'];
	$company_id = $_POST['edit_company_id'];

	$sql = "UPDATE tb_company
			SET company_name = '$company_name',
				company_cat = '$company_cat',
				company_ssm = '$company_ssm',
				company_address = '$company_address'
			WHERE company_id = '$company_id'";

	$result = mysqli_query($con,$sql) or die(mysqli_error($con));
	mysqli_close($con);
	header('Location:../../company.php');

?>
