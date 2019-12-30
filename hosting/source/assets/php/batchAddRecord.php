<?php
	
	require('dbconnect.php');
	date_default_timezone_set("Asia/Kuala_Lumpur");

	$batch_uid  = $_POST['batch_uid'];
	$recordArr  = $_POST['record'];
	$stock  = $_POST['stock'];
	if(isset($_POST['status'])){	//////only needed when the projetc is initializing
		$status  = $_POST['status'];
	}else{
		$status = false;
	}
	if(isset($_POST['date'])){
		$date = $_POST['date'];
	}else{
		$date = date('Y-m-d');
	}

	var_dump($stock);


	foreach ($recordArr as $record) {

		$birdObj = $record['bird_record'];
		
		$birdRecordOperation = $birdObj['operation'];
		$bird_house_id = $birdObj['house_id'];
		$bird_death= $birdObj['bird_death'];
		$bird_cull = $birdObj['bird_cull'];
		$bird_catch = $birdObj['bird_catch'];
		$bird_balance = $birdObj['bird_balance'];
		$bird_batch_uid = $birdObj['bird_batch_uid'];

		switch ($birdRecordOperation) {
			case 'insert':
				
				$sqlInsertBird = "INSERT INTO tb_bird(bird_death, bird_cull, bird_catch, bird_balance, bird_record_date, bird_house_id, bird_batch_uid) VALUES('$bird_death', '$bird_cull', '$bird_catch', '$bird_balance', '$date', '$bird_house_id', '$bird_batch_uid')";
				$result = mysqli_query($con,$sqlInsertBird) or die(mysqli_error($con));

				$lastBirdId = mysqli_insert_id($con);

				if(isset($birdObj['bird_weight'])){
					$bird_weight = $birdObj['bird_weight'];
					$bird_price = $birdObj['bird_price'];
					$bird_profit = $birdObj['bird_profit'];

					$sqlInsertWeight = "INSERT INTO tb_weight(weight_bird_id,weight_data) VALUES('$lastBirdId','$bird_weight')";
					$result = mysqli_query($con,$sqlInsertWeight) or die(mysqli_error($con));

					$sqlUpdateEvent = "UPDATE tb_event SET event_state = '0' WHERE event_date = '$date'";
					$result = mysqli_query($con,$sqlUpdateEvent) or die(mysqli_error($con));

					if($bird_catch > 0){

						$sqlProfit = "INSERT INTO tb_profit(profit_bird_id,profit_bird_price,profit_amount) VALUES('$lastBirdId','$bird_price','$bird_profit')";
						$resultProfit = mysqli_query($con,$sqlProfit) or die(mysqli_error($con));
					}

				}

				break;

			case 'edit':

				$bird_id = $birdObj['bird_id'];

				$sqlEditBird = "UPDATE tb_bird SET bird_death = '$bird_death', bird_cull = '$bird_cull', bird_catch = '$bird_catch', bird_balance = '$bird_balance' WHERE bird_id = '$bird_id'";
				$result = mysqli_query($con,$sqlEditBird) or die(mysqli_error($con));

				if(isset($birdObj['bird_weight'])){

					$sqlCheckWeight = "SELECT * FROM tb_weight WHERE weight_bird_id = '$bird_id'";
					$resultCheckWeight = mysqli_query($con,$sqlCheckWeight);
					if(mysqli_num_rows($resultCheckWeight) > 0){
						$bird_weight = $birdObj['bird_weight'];

						$sqlUpdateWeight = "UPDATE tb_weight SET weight_data = '$bird_weight' WHERE weight_bird_id = '$bird_id'";
						$result = mysqli_query($con,$sqlUpdateWeight) or die(mysqli_error($con));
					}else{
						$bird_weight = $birdObj['bird_weight'];

						$sqlInsertWeight = "INSERT INTO tb_weight(weight_bird_id,weight_data) VALUES('$bird_id','$bird_weight')";
						$result = mysqli_query($con,$sqlInsertWeight) or die(mysqli_error($con));						
					}

					$sqlUpdateEvent = "UPDATE tb_event SET event_state = '0' WHERE event_date = '$date'";
					$result = mysqli_query($con,$sqlUpdateEvent) or die(mysqli_error($con));

					$bird_price = $birdObj['bird_price'];
					$bird_profit = $birdObj['bird_profit'];

					$sqlProfitEdit = "UPDATE tb_profit SET profit_bird_price = '$bird_price', profit_amount = '$bird_profit' WHERE profit_bird_id = '$bird_id'";
					$resultProfitEdit = mysqli_query($con,$sqlProfitEdit) or die(mysqli_error($con));

				}


				break;
			
			default:
				# code...
				break;
		}

		$feedArr = $record['feed_record'];

		foreach ($feedArr as $feedObj) {

			$feedRecordOperation = $feedObj['operation'];
			$sr_item = $feedObj['feed_id'];
			$sr_item_quantity = $feedObj['feed_quantity'];
			$sr_stock = $feedObj['feed_stock_id'];
			$sr_record_type = $feedObj['feed_type'];
			$sr_house_id = $feedObj['feed_house_id'];

			switch ($feedRecordOperation) {
				case 'insert':
					
					$sqlInsertFeedRecord = "INSERT INTO tb_stock_record(sr_stock,sr_item,sr_item_quantity,sr_record_date,sr_record_type,sr_batch_uid,sr_house_id)
											VALUES('$sr_stock','$sr_item','$sr_item_quantity','$date','$sr_record_type','$bird_batch_uid','$sr_house_id')";
					$result = mysqli_query($con,$sqlInsertFeedRecord) or die(mysqli_error($con));

					break;

				case 'edit':
					$sr_id = $feedObj['feed_sr_id'];
					$sqlEditStockRecord = "UPDATE tb_stock_record SET sr_item_quantity = '$sr_item_quantity' WHERE sr_id = '$sr_id'";
					$result = mysqli_query($con,$sqlEditStockRecord) or die(mysqli_error($con));
					break;
				
				default:
					# code...
					break;
			}

		}

		


		$houseObj = $record['house_record'];
		
		$houseRecordOperation = $houseObj['operation'];
		$house_id = $houseObj['house_id'];
		$house_used_capacity = $houseObj['house_used_capacity'];

		switch ($houseRecordOperation) {
			case 'update':
				
				$sqlUpdateHouse = "UPDATE tb_house SET house_used_capacity = $house_used_capacity WHERE house_id = '$house_id'";
				$result = mysqli_query($con,$sqlUpdateHouse) or die(mysqli_error($con));
				break;
			
			default:
				# code...
				break;
		}



	}

	foreach ($stock as $stockObj) {
		
		$sb_stock_id = $stockObj['sb_stock_id'];
		$sb_item = $stockObj['sb_item'];
		$sb_balance = $stockObj['sb_balance'];

		$sqlUpdateStock = "UPDATE tb_stock_balance SET sb_balance = '$sb_balance' WHERE sb_stock_id = '$sb_stock_id' AND sb_item = '$sb_item'";
		$result = mysqli_query($con,$sqlUpdateStock);

	}

	if($status == 'initialized'){

		$sqlCode = "SELECT * FROM tb_category WHERE category_desc = 'active' AND category_level ='batch_status'";
		$resultCode = mysqli_query($con,$sqlCode);
		$rowCode = mysqli_fetch_assoc($resultCode);
		$batchStatusActive = $rowCode['category_id'];

		$sqlUpdateBatchStatus = "UPDATE tb_batch SET batch_status = '$batchStatusActive' WHERE batch_uid = '$batch_uid'";
		$result = mysqli_query($con,$sqlUpdateBatchStatus);

	}

	$sqlBatchHouse = "SELECT bh_house_id FROM tb_batch_house WHERE bh_batch_uid = '$batch_uid'";
	$resultBatchHouse =  mysqli_query($con,$sqlBatchHouse);

	while($rowBatchHouse = mysqli_fetch_assoc($resultBatchHouse)){

		$house_id = $rowBatchHouse["bh_house_id"];

		$sqlUpdateBalance = "SELECT * FROM tb_bird WHERE bird_house_id = '$house_id' AND bird_batch_uid = '$batch_uid' ORDER BY date(bird_record_date) ASC ";
		$resultUpdateBalance = mysqli_query($con,$sqlUpdateBalance) or die(mysqli_error($con));

		$count = 0;
		
		while ($rowUpdateBalance = mysqli_fetch_assoc($resultUpdateBalance)){
			$currentBirdId = $rowUpdateBalance['bird_id'];
			if($count == 0){
				$currentBalance = $rowUpdateBalance['bird_balance'];
			}

			$currentBalance = $currentBalance - ($rowUpdateBalance['bird_death'] + $rowUpdateBalance['bird_cull'] + $rowUpdateBalance['bird_catch']);

			$sqlUpdateRecord = "UPDATE tb_bird SET bird_balance = '$currentBalance' WHERE bird_id = '$currentBirdId'";
			$resultUpdateRecord = mysqli_query($con,$sqlUpdateRecord);

			$count = $count + 1;

		}

	}





	mysqli_close($con);
?>