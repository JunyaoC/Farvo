<?php
	
	require('dbconnect.php');

	$sql = "SELECT * FROM tb_category";
	$result = mysqli_query($con,$sql);


	$catArr = array();

	while($row = mysqli_fetch_assoc($result)){
	
		$newCat = new \stdClass();

		$newCat->category_desc = $row['category_desc'];
		$newCat->category_code = $row['category_code'];
		$newCat->category_id = $row['category_id'];
		$newCat->category_level = $row['category_level'];

		array_push($catArr, $newCat);

	}

	echo json_encode($catArr);
	mysqli_close($con);

?>