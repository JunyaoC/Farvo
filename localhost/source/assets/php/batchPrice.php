<?php
	
	require('dbconnect.php');

	$batch_price  = $_POST['batch_price'];

	foreach ($batch_price as $batch_price_obj) {
		
		$operation = $batch_price_obj['operation'];

		switch($operation){

			case 'edit':

				$batch_price_id = $batch_price_obj['batch_price_id'];
				$batch_price = $batch_price_obj['batch_price'];

				$sql = "UPDATE tb_category SET category_desc = '$batch_price' WHERE category_id = '$batch_price_id'";
				$result = mysqli_query($con,$sql);
				break;

			case 'insert':

				$batch_cat_id = $batch_price_obj['batch_cat_id'];
				$batch_price = $batch_price_obj['batch_price'];

				$sql = "INSERT INTO tb_category(category_code,category_desc,category_level)
						VALUES('$batch_cat_id','$batch_price','batch_price')";
				$result = mysqli_query($con,$sql);
				
				break;



		}


	}

	mysqli_close($con);	

?>