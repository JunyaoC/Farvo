<?php

	require('dbconnect.php');
	$company_id = $_POST["company_id"];
	$accessLevel = $_POST["accessLevel"];

	$sql = "SELECT *
			FROM tb_access
			LEFT JOIN tb_user ON tb_access.access_user_id = tb_user.user_id
			WHERE access_company_id = '$company_id'";

	$result = mysqli_query($con,$sql);

	

	if(mysqli_num_rows($result) < 1){
		echo "No Staff in this company yet.";
	}else{
		echo "
		<table class='table table-hover'>
			<tr>
				<th>Name</th>
				<th>Role</th>";
				
				if($accessLevel == 4){
					echo "<th colspan='2' class='text-center'>Action</th>";
				}

				echo "
			</tr>
		";
		while($row = mysqli_fetch_assoc($result)){
			echo "
			<tr>
				<td>".$row['user_name']."</td>";

			switch($row['access_level']){

				case '1':
					$desc = 'Farmer';
					break;

				case '2':
					$desc = 'Stakeholder';
					break;

				case '3':
					$desc = 'Staff';
					break;

				case '4':
					$desc = 'Admin';
					break;


			};

			if($accessLevel == 4 ){
				echo "
					<td>".$desc."</td>
					<td><button class='userEditAccess btn btn-warning' compId='".$company_id."' userId='".$row['access_user_id']."'  >Edit</button></td>
					<td><button class='userRemove btn btn-danger' compId='".$company_id."' userId='".$row['access_user_id']."'>Remove</button></td>
				</tr>
				";
			} else{
				echo "
					<td>".$desc."</td>
				</tr>
				";
			}

		}

		echo "</table>";
	}


?>