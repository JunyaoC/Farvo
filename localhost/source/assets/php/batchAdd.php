<?php
	
	require('dbconnect.php');

	$batch_uid  = $_POST['batch_uid'];
	$batch_name  = $_POST['batch_name'];
	$batch_type  = $_POST['batch_type'];
	$init_house_arr  = $_POST['houseInitQuantity'];
	$batch_status  = $_POST['batch_status'];
	$batch_company  = $_POST['batch_company'];
	$batch_cycle_id  = $_POST['batch_cycle_id'];
	$batch_price_per_bird  = $_POST['batch_price_per_bird'];
	$batch_cost_id  = $_POST['batch_cost_id'];

	

	$totalQuantity = 0;

	date_default_timezone_set("Asia/Kuala_Lumpur");

	foreach ($init_house_arr as $house) {

		$house_id = $house['house_id'];
		$quantity = $house['quantity'];

		$totalQuantity = $totalQuantity + $quantity;
			
		$sql = "INSERT INTO tb_bird(bird_death,bird_cull,bird_catch,bird_balance,bird_record_date,bird_house_id,bird_batch_uid)
				VALUES('0','0','0','$quantity',curdate(),'$house_id','$batch_uid')";
		$result = mysqli_query($con,$sql);




		$sqlBatchHouse = "INSERT INTO tb_batch_house(bh_batch_uid,bh_house_id)
				VALUES('$batch_uid','$house_id')";
		$resultBatchHouse = mysqli_query($con,$sqlBatchHouse) or die(mysqli_error($con));





		$sqlUpdateHouse = "SELECT * FROM tb_house WHERE house_id = '$house_id'"; 
		$resultUpdateHouse = mysqli_query($con,$sqlUpdateHouse);

		while($rowUpdateHouse = mysqli_fetch_assoc($resultUpdateHouse)){

			$currentUsedCapacity = $rowUpdateHouse['house_used_capacity'];
			$newCapacity = $currentUsedCapacity + $quantity;

			$sqlUpdate ="UPDATE tb_house SET house_used_capacity = '$newCapacity' WHERE house_id = '$house_id'";
			$resultUpdate = mysqli_query($con,$sqlUpdate);
		}




	}

	$sqlUpdate ="INSERT tb_batch(batch_uid, batch_name,batch_type, batch_company, batch_date, batch_status,batch_cycle_id) VALUES('$batch_uid','$batch_name','$batch_type', '$batch_company', curdate(), '$batch_status','$batch_cycle_id')";
	$resultUpdate = mysqli_query($con,$sqlUpdate);

	$sqlBatchCycle ="INSERT tb_cycle_batch(cb_cycle_id, cb_batch_uid) VALUES('$batch_cycle_id','$batch_uid')";
	$resultBatchCycle = mysqli_query($con,$sqlBatchCycle) or die(mysqli_error($con));

	$totalPrice = $totalQuantity * $batch_price_per_bird;
	$costRemark = $totalQuantity." birds x RM".$batch_price_per_bird." = RM".$totalPrice;



	$sqlCost = "INSERT INTO tb_cost(cost_date,cost_category,cost_amount,cost_note,cost_cycle_id)
			VALUES(curdate(),'$batch_cost_id','$totalPrice','$costRemark','$batch_cycle_id')";
	$result = mysqli_query($con,$sqlCost);
	
	mysqli_close($con);



?>