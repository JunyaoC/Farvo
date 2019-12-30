<?php
		
	require('dbconnect.php');
	
	$cycle_id = $_GET['cycle_id'];

	$cycleObj = new \stdClass();

	$sqlCycle = "SELECT * FROM tb_cycle WHERE cycle_id = '$cycle_id'";
	$resultCycle = mysqli_query($con,$sqlCycle);

	while($rowCycle = mysqli_fetch_assoc($resultCycle)){
		$cycleObj->cycle_id = $rowCycle['cycle_id'];
		$cycleObj->cycle_farm_id = $rowCycle['cycle_farm_id'];
		$cycleObj->cycle_init_date = $rowCycle['cycle_init_date'];
		$cycleObj->cycle_status = $rowCycle['cycle_status'];
		$cycleObj->cycle_name = $rowCycle['cycle_name'];
		$cycleObj->cycle_end_date = $rowCycle['cycle_end_date'];

	}

	$sqlCB = "SELECT * FROM tb_cycle_batch WHERE cb_cycle_id = '$cycle_id'";
	$resultCB = mysqli_query($con,$sqlCB);

	$batchArr = array();
	
	while($rowCB = mysqli_fetch_assoc($resultCB)){

		$batchObj = new \stdClass();

		$batchObj->batch_uid = $rowCB['cb_batch_uid'];

		$sqlBatch = "SELECT * FROM tb_batch WHERE batch_uid = '$batchObj->batch_uid'";
		$resultBatch = mysqli_query($con,$sqlBatch);

		while($rowBatch = mysqli_fetch_assoc($resultBatch)){

			$batchObj->batch_name = $rowBatch['batch_name'];
			$batchObj->batch_type = $rowBatch['batch_type'];
			$batchObj->batch_company = $rowBatch['batch_company'];
			$batchObj->batch_date = $rowBatch['batch_date'];
			$batchObj->batch_status = $rowBatch['batch_status'];

			$birdArr = array();

			$sqlBird = "SELECT * FROM tb_bird WHERE bird_batch_uid = '$batchObj->batch_uid'";
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

			$batchObj->batch_record = $birdArr;

			$stockRecordArr = array();

			$sqlStockRecord = "SELECT * FROM tb_stock_record WHERE sr_batch_uid = '$batchObj->batch_uid'";
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

			$batchObj->batch_stock_record = $stockRecordArr;




		}

		array_push($batchArr, $batchObj);

	}

	$cycleObj->batch = $batchArr;

	$sqlCost = "SELECT * FROM tb_cost WHERE cost_cycle_id = '$cycle_id'";
	$resultCost = mysqli_query($con,$sqlCost);

	$costArr = array();

	while($rowCost = mysqli_fetch_assoc($resultCost)){

		$newCost = new \stdClass();
		$newCost->cost_id = $rowCost['cost_id'];
		$newCost->cost_date = $rowCost['cost_date'];
		$newCost->cost_category = $rowCost['cost_category'];
		$newCost->cost_amount = $rowCost['cost_amount'];
		$newCost->cost_note = $rowCost['cost_note'];
		$newCost->cost_cycle_id = $rowCost['cost_cycle_id'];

		array_push($costArr,$newCost);

	}

	$cycleObj->cycle_cost = $costArr;

	echo json_encode($cycleObj);
	mysqli_close($con);

?>