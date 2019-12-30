<?php

	include('dbconnect.php');
	$company_id = $_POST['company_id'];

	$newDashboard = new \stdClass();

	$sqlFarm = "SELECT * FROM tb_farm WHERE farm_company_id = '$company_id'";
	$resultFarm = mysqli_query($con,$sqlFarm);

	$farmArr = array();

	while($rowFarm = mysqli_fetch_assoc($resultFarm)){

		$newFarmObj = new \stdClass();

		$newFarmObj->farm_id = $rowFarm['farm_id'];
		$newFarmObj->farm_address = $rowFarm['farm_address'];
		$newFarmObj->farm_joinDt = $rowFarm['farm_joinDt'];
		$newFarmObj->farm_company_id = $rowFarm['farm_company_id'];
		$newFarmObj->farm_cat = $rowFarm['farm_cat'];
		$newFarmObj->farm_name = $rowFarm['farm_name'];

		$sqlAllFarmer = "SELECT * FROM tb_access JOIN tb_user ON tb_access.access_user_id = tb_user.user_id WHERE tb_access.access_level = '1' AND tb_access.access_company_id = (SELECT farm_company_id FROM tb_farm WHERE farm_id  = '$newFarmObj->farm_id')";
		$resultAllFarmer = mysqli_query($con,$sqlAllFarmer);

		$farmerAccessArr = array();

		while($rowAllFarmer = mysqli_fetch_assoc($resultAllFarmer)){

			$farmerObj = new \stdClass();

			$farmerObj->user_id = $rowAllFarmer['user_id'];
			$farmerObj->user_name = $rowAllFarmer['user_name'];
			$farmerObj->user_email = $rowAllFarmer['user_email'];
			$farmerObj->user_phone = $rowAllFarmer['user_phone'];

			$sqlFarmerAccess = "SELECT * FROM tb_farm_access WHERE fa_user_id = '$farmerObj->user_id' AND fa_farm_id = '$newFarmObj->farm_id'";
			$resultFarmerAccess = mysqli_query($con,$sqlFarmerAccess);

			if(mysqli_num_rows($resultFarmerAccess) > 0){
				$farmerObj->access = 1;
			}else{
				$farmerObj->access = 0;
			}

			array_push($farmerAccessArr, $farmerObj);

		}

		$newFarmObj->farm_access = $farmerAccessArr;

		array_push($farmArr, $newFarmObj);
	}

	$sqlHouse = "SELECT * FROM tb_house JOIN tb_farm ON tb_house.house_farm_id = tb_farm.farm_id WHERE tb_farm.farm_company_id = '$company_id'";
	$resultHouse = mysqli_query($con,$sqlHouse);

	$houseArr = array();

	while($rowHouse = mysqli_fetch_assoc($resultHouse)){

		$newHouseObj = new \stdClass();

		$newHouseObj->house_id = $rowHouse['house_id'];
		$newHouseObj->house_capacity = $rowHouse['house_capacity'];
		$newHouseObj->house_cat = $rowHouse['house_cat'];
		$newHouseObj->house_farm_id = $rowHouse['house_farm_id'];
		$newHouseObj->house_status = $rowHouse['house_status'];
		$newHouseObj->house_used_capacity = $rowHouse['house_used_capacity'];
		$newHouseObj->house_name = $rowHouse['house_name'];


		array_push($houseArr, $newHouseObj);
	}

	$sqlStock = "SELECT * FROM tb_stock JOIN tb_farm ON tb_stock.stock_farm_id = tb_farm.farm_id WHERE tb_farm.farm_company_id = '$company_id'";
	$resultStock = mysqli_query($con,$sqlStock);

	$stockArr = array();

	while($rowStock = mysqli_fetch_assoc($resultStock)){

		$newStock = new \stdClass();

		$newStock->stock_id = $rowStock['stock_id'];
		$newStock->stock_farm_id = $rowStock['stock_farm_id'];
		$newStock->stock_name = $rowStock['stock_name'];

		$sqlStockBalance = "SELECT * FROM tb_stock_balance WHERE sb_stock_id = '$newStock->stock_id'";
		$resultStockBalance = mysqli_query($con,$sqlStockBalance);

		$newFeedBalanceArr = array();

		while($rowStockBalance = mysqli_fetch_assoc($resultStockBalance)){

			$newFeedBalance = new \stdClass();

			$newFeedBalance->sb_item = $rowStockBalance['sb_item'];
			$newFeedBalance->sb_balance = $rowStockBalance['sb_balance'];

			array_push($newFeedBalanceArr, $newFeedBalance);
		}

		$newStock->stock_balance = $newFeedBalanceArr;

		array_push($stockArr, $newStock);
	}


	$sqlCycle = "SELECT * FROM tb_cycle JOIN tb_farm ON tb_cycle.cycle_farm_id = tb_farm.farm_id JOIN tb_category ON tb_cycle.cycle_status = tb_category.category_id WHERE tb_farm.farm_company_id = '$company_id'";
	$resultCycle = mysqli_query($con,$sqlCycle);

	$cycleArr = array();

	while($rowCycle = mysqli_fetch_assoc($resultCycle)){

		$newCycle = new \stdClass();

		$newCycle->cycle_id = $rowCycle['cycle_id'];
		$newCycle->cycle_farm_id = $rowCycle['cycle_farm_id'];
		$newCycle->cycle_init_date = $rowCycle['cycle_init_date'];
		$newCycle->cycle_status = $rowCycle['category_desc'];
		$newCycle->cycle_name = $rowCycle['cycle_name'];

		$sqlCost = "SELECT * FROM tb_cost WHERE cost_cycle_id = '$newCycle->cycle_id'";
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

		$newCycle->cycle_cost = $costArr;

		array_push($cycleArr, $newCycle);
	}

	$sqlBatch = "SELECT * FROM tb_batch WHERE batch_company = '$company_id'";
	$resultBatch = mysqli_query($con,$sqlBatch);

	$batchArr = array();

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

		$batch_house_balance = array();

		$sqlBatchHouseBalance = "SELECT * FROM tb_batch_house WHERE bh_batch_uid = '$newBatch->batch_uid'";
		$reusultHouseBalance = mysqli_query($con,$sqlBatchHouseBalance);

		while($rowBatchHouseBalance = mysqli_fetch_assoc($reusultHouseBalance)){

			$batchHouseObj = new \stdClass();

			$houseId = $rowBatchHouseBalance['bh_house_id'];
			$sqlBatchHouseBalanceValue = "SELECT * FROM tb_bird WHERE bird_batch_uid = '$newBatch->batch_uid' AND bird_house_id = '$houseId' AND bird_record_date = (SELECT MAX(bird_record_date) FROM tb_bird WHERE bird_batch_uid = '$newBatch->batch_uid')";
			$resultBatchHouseBalanceValue = mysqli_query($con,$sqlBatchHouseBalanceValue);

			while($rowBatchHouseBalanceValue = mysqli_fetch_assoc($resultBatchHouseBalanceValue)){
				$batchHouseObj->house = $houseId;
				$batchHouseObj->balance = $rowBatchHouseBalanceValue['bird_balance'];
			}

			array_push($batch_house_balance, $batchHouseObj);

		}

		$newBatch->batch_house_balance = $batch_house_balance;


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



	$newDashboard->farm = $farmArr;
	$newDashboard->house = $houseArr;
	$newDashboard->stock = $stockArr;
	$newDashboard->cycle = $cycleArr;
	$newDashboard->batch = $batchArr;

	echo json_encode($newDashboard);

	mysqli_close($con);

?>