<?php

	include('dbconnect.php');
	$user_id = $_POST['user_id'];

	$sqlAccess = "SELECT * FROM tb_farm_access WHERE fa_user_id = '$user_id'";
	$resultAccess = mysqli_query($con,$sqlAccess) or die(mysqli_error($con));

	$response = new \stdClass();
	$batchArr = array();


	while($rowAccess = mysqli_fetch_assoc($resultAccess)){

		$farm_id = $rowAccess['fa_farm_id'];

		$sqlBatch = "SELECT * FROM tb_batch JOIN tb_cycle ON tb_batch.batch_cycle_id = tb_cycle.cycle_id WHERE tb_cycle.cycle_farm_id = '$farm_id'";
		$resultBatch = mysqli_query($con,$sqlBatch) or die(mysqli_error($con));

			

			while($rowBatch = mysqli_fetch_assoc($resultBatch)){

				$newBatch = new \stdClass();

				$newBatch->batch_uid = $rowBatch['batch_uid'];
				$newBatch->batch_name = $rowBatch['batch_name'];
				$newBatch->batch_type = $rowBatch['batch_type'];
				$newBatch->batch_company = $rowBatch['batch_company'];
				$newBatch->batch_date = $rowBatch['batch_date'];
				$newBatch->batch_status = $rowBatch['batch_status'];
				$newBatch->batch_cycle_id = $rowBatch['batch_cycle_id'];

				$birdArr = array();

				$sqlBird = "SELECT * FROM tb_bird WHERE bird_batch_uid = '$newBatch->batch_uid'";
				$resultBird = mysqli_query($con,$sqlBird);

				while($rowBird = mysqli_fetch_assoc($resultBird)){

					$newBirdRecord = new \stdClass();

					$newBirdRecord->bird_id = $rowBird['bird_id'];
					$newBirdRecord->bird_death = $rowBird['bird_death'];
					$newBirdRecord->bird_cull = $rowBird['bird_cull'];
					$newBirdRecord->bird_catch = $rowBird['bird_catch'];
					$newBirdRecord->bird_balance = $rowBird['bird_balance'];
					$newBirdRecord->bird_record_date = $rowBird['bird_record_date'];
					$newBirdRecord->bird_house_id = $rowBird['bird_house_id'];
					$newBirdRecord->bird_batch_uid = $rowBird['bird_batch_uid'];

					$sqlWeight = "SELECT * FROM tb_weight WHERE weight_bird_id = '$newBirdRecord->bird_id'";
					$resultWeight = mysqli_query($con,$sqlWeight);

					while($rowWeight = mysqli_fetch_assoc($resultWeight)){
						$newBirdRecord->bird_weight = $rowWeight['weight_data'];
					}

					$sqlProfit = "SELECT * FROM tb_profit WHERE profit_bird_id = '$newBirdRecord->bird_id'";
					$resultProfit = mysqli_query($con,$sqlProfit);

					while($rowProfit = mysqli_fetch_assoc($resultProfit)){
						$newBirdRecord->bird_profit = $rowProfit['profit_amount'];
						$newBirdRecord->bird_profit_id = $rowProfit['profit_id'];
						$newBirdRecord->bird_price = $rowProfit['profit_bird_price'];
					}		


					array_push($birdArr, $newBirdRecord);

				}

				$newBatch->batch_record = $birdArr;

				$stockRecordArr = array();

				$sqlStockRecord = "SELECT * FROM tb_stock_record WHERE sr_batch_uid = '$newBatch->batch_uid'";
				$resultStockRecord = mysqli_query($con,$sqlStockRecord);

				while($rowStockRecord = mysqli_fetch_assoc($resultStockRecord)){

					$newStockRecord = new \stdClass();

					$newStockRecord->sr_id = $rowStockRecord['sr_id'];
					$newStockRecord->sr_stock = $rowStockRecord['sr_stock'];
					$newStockRecord->sr_item = $rowStockRecord['sr_item'];
					$newStockRecord->sr_item_quantity = $rowStockRecord['sr_item_quantity'];
					$newStockRecord->sr_record_date = $rowStockRecord['sr_record_date'];
					$newStockRecord->sr_record_type = $rowStockRecord['sr_record_type'];
					$newStockRecord->sr_batch_uid = $rowStockRecord['sr_batch_uid'];
					$newStockRecord->sr_house_id = $rowStockRecord['sr_house_id'];


					array_push($stockRecordArr, $newStockRecord);

				}

				$newBatch->batch_stock_record = $stockRecordArr;

				$eventArr = array();

				$sqlEvent = "SELECT * FROM tb_event WHERE event_batch_uid = '$newBatch->batch_uid'";
				$resultEvent = mysqli_query($con,$sqlEvent);

				while($rowEvent = mysqli_fetch_assoc($resultEvent)){

					$newEvent = new \stdClass();

					$newEvent->event_id = $rowEvent['event_id'];
					$newEvent->event_type = $rowEvent['event_type'];
					$newEvent->event_date = $rowEvent['event_date'];
					$newEvent->event_batch_uid = $rowEvent['event_batch_uid'];
					$newEvent->event_state = $rowEvent['event_state'];
					$newEvent->event_note = $rowEvent['event_note'];

					array_push($eventArr, $newEvent);

				}



				$newBatch->batch_event = $eventArr;



				array_push($batchArr, $newBatch);
			}




	}

	$response->batch = $batchArr;

			echo json_encode($response);



?>