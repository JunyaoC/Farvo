<?php
	
	require('dbconnect.php');

	$operation  = $_POST['operation'];
	$feed_price_amount  = $_POST['feed_price_amount'];
		
	if(isset($_POST['feed_id'])){
		$feed_id  = $_POST['feed_id'];
	}
	if(isset($_POST['feed_price_id'])){
		$feed_price_id = $_POST['feed_price_id'];
	}

	switch ($operation) {
		case 'set':
			$sql = "INSERT INTO tb_category(category_level,category_code,category_desc)
			VALUES('feed_price','$feed_id','$feed_price_amount')";
			$result = mysqli_query($con,$sql) or die(mysqli_error($con));
		break;		

		case 'edit':
			$sql = "UPDATE tb_category SET category_desc = '$feed_price_amount' WHERE category_id = '$feed_price_id'";
			$result = mysqli_query($con,$sql) or die(mysqli_error($con));
		break;		
	}

	mysqli_close($con);


?>