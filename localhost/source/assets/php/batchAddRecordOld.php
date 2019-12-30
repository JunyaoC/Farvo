<?php
	
	require('dbconnect.php');
	date_default_timezone_set("Asia/Kuala_Lumpur");

	$batch_uid  = $_POST['batch_uid'];
	$recordArr  = $_POST['record'];
	$recordDate  = $_POST['date'];
	$operation  = $_POST['operation'];

	$sqlCode = "SELECT * FROM tb_category WHERE category_desc = 'feeding'";
    $resultCode = mysqli_query($con,$sqlCode);
    $rowCode = mysqli_fetch_assoc($resultCode);
    $recordTypeFeeding = $rowCode['category_id'];

	switch ($operation) {
		case 'insert':
					foreach ($recordArr as $record) {

						$house_id = $record['house_id'];
						$bird_death = $record['bird_death'];
						$bird_cull = $record['bird_cull'];
						$bird_catch = $record['bird_catch'];

						$sqlBalance = "SELECT bird_balance FROM tb_bird WHERE bird_id = (SELECT MAX(bird_id) FROM tb_bird WHERE bird_batch_uid = '$batch_uid' AND bird_house_id = '$house_id')";
						$resultBalance = mysqli_query($con,$sqlBalance);
						$rowBalance = mysqli_fetch_assoc($resultBalance);
						$balance = $rowBalance['bird_balance'];
						$birdLost = $bird_death + $bird_cull + $bird_catch;
						echo $birdLost;
						$balance = $balance - $birdLost;
							
						$sql = "INSERT INTO tb_bird(bird_death,bird_cull,bird_catch,bird_balance,bird_record_date,bird_house_id,bird_batch_uid)
								VALUES('$bird_death','$bird_cull','$bird_catch','$balance','$recordDate','$house_id','$batch_uid')";

						$result = mysqli_query($con,$sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error(), E_USER_ERROR);

						$feedArr = $record['feed'];

						foreach ($feedArr as $feed) {
							$feed_id = $feed['feed_id'];
							$quantity = $feed['quantity'];
							$stock = $feed['stock'];

							$sqlFeedBalance = "SELECT * FROM tb_stock_balance WHERE sb_stock_id = '$stock' AND sb_item = '$feed_id'";
							$resultFeedBalance = mysqli_query($con,$sqlFeedBalance) or die(mysqli_error($con));
							$rowFeedBalance = mysqli_fetch_assoc($resultFeedBalance);
							$feedBalance = $rowFeedBalance['sb_balance'];

							if(($feedBalance >= $quantity) && ($quantity != NULL)){
								$sqlSR = "INSERT INTO tb_stock_record(sr_stock,sr_item,sr_item_quantity,sr_record_date,sr_record_type,sr_batch_uid)
											VALUES('$stock','$feed_id','$quantity','$recordDate','$recordTypeFeeding','$batch_uid')";
								$resultSR = mysqli_query($con,$sqlSR) or die(mysqli_error($con));

								$newBalance = $feedBalance - $quantity;
								$sqlFeedUpdate = "UPDATE tb_stock_balance SET sb_balance = '$newBalance' WHERE sb_stock_id = '$stock' AND sb_item = '$feed_id'";
								$resultFeedUpdate = mysqli_query($con,$sqlFeedUpdate);
							} else{
								echo "Not Enough Feed For Feed ID ".$feed_id;
							}
					


						}


					}
			break;

		case 'update':

			foreach ($recordArr as $record) {

				$house_id = $record['house_id'];
				$bird_death = $record['bird_death'];
				$bird_cull = $record['bird_cull'];
				$bird_catch = $record['bird_catch'];

				$balance = 0;
				$balance = $balance - ($bird_death + $bird_cull + $bird_catch);
					
				$sql = "INSERT INTO tb_bird(bird_death,bird_cull,bird_catch,bird_balance,bird_record_date,bird_house_id,bird_batch_uid)
						VALUES('$bird_death','$bird_cull','$bird_catch','$balance','$recordDate','$house_id','$batch_uid')";

				$result = mysqli_query($con,$sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error(), E_USER_ERROR);


				$feedArr = $record['feed'];

				foreach ($feedArr as $feed) {
					$feed_id = $feed['feed_id'];
					$quantity = $feed['quantity'];
					$stock = $feed['stock'];
					
					$sqlFeedBalance = "SELECT * FROM tb_stock_balance WHERE sb_stock_id = '$stock' AND sb_item = '$feed_id'";
					$resultFeedBalance = mysqli_query($con,$sqlFeedBalance) or die(mysqli_error($con));
					$rowFeedBalance = mysqli_fetch_assoc($resultFeedBalance);
					$feedBalance = $rowFeedBalance['sb_balance'];

					if($feedBalance >= $quantity){
						$sqlSR = "INSERT INTO tb_stock_record(sr_stock,sr_item,sr_item_quantity,sr_record_date,sr_record_type,sr_batch_uid)
									VALUES('$stock','$feed_id','$newBalance','$recordDate','$recordTypeFeeding','$batch_uid')";
						$resultSR = mysqli_query($con,$sqlSR) or die(mysqli_error($con));

						$newBalance = $feedBalance - $quantity;
						$sqlFeedUpdate = "UPDATE tb_stock_balance SET sb_balance = '$newBalance' WHERE sb_stock_id = '$stock' AND sb_item = '$feed_id'";
						$resultFeedUpdate = mysqli_query($con,$sqlFeedUpdate);
					}else{
						echo "Not Enough Feed For Feed ID ".$feed_id;
					}


				}



			}

			$sqlUpdateBalance = "SELECT * FROM tb_bird WHERE bird_batch_uid = '$batch_uid' ORDER BY date(bird_record_date) ASC";
			$resultUpdateBalance = mysqli_query($con,$sqlUpdateBalance);

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




				
			break;

		case 'initialize':
			if($recordArr){
				foreach ($recordArr as $record) {

					$house_id = $record['house_id'];
					$bird_death = $record['bird_death'];
					$bird_cull = $record['bird_cull'];
					$bird_catch = $record['bird_catch'];
					$feed = $record['feed'];


					$sqlBalance = "SELECT bird_balance FROM tb_bird WHERE bird_id = (SELECT MAX(bird_id) FROM tb_bird WHERE bird_batch_uid = '$batch_uid' AND bird_house_id = '$house_id')";
					$resultBalance = mysqli_query($con,$sqlBalance);
					$rowBalance = mysqli_fetch_assoc($resultBalance);
					$balance = $rowBalance['bird_balance'];
					$birdLost = $bird_death + $bird_cull + $bird_catch;
					echo $birdLost;
					$balance = $balance - $birdLost;
						
					$sql = "INSERT INTO tb_bird(bird_death,bird_cull,bird_catch,bird_balance,bird_record_date,bird_house_id,bird_batch_uid)
							VALUES('$bird_death','$bird_cull','$bird_catch','$balance','$recordDate','$house_id','$batch_uid')";

					$result = mysqli_query($con,$sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error(), E_USER_ERROR);

					$feedArr = $record['feed'];

					foreach ($feedArr as $feed) {
						$feed_id = $feed['feed_id'];
						$quantity = $feed['quantity'];
						$stock = $feed['stock'];

						$sqlFeedBalance = "SELECT * FROM tb_stock_balance WHERE sb_stock_id = '$stock' AND sb_item = '$feed_id'";
						$resultFeedBalance = mysqli_query($con,$sqlFeedBalance) or die(mysqli_error($con));
						$rowFeedBalance = mysqli_fetch_assoc($resultFeedBalance);
						$feedBalance = $rowFeedBalance['sb_balance'];

						if(($feedBalance >= $quantity) && ($quantity != NULL)){
							$sqlSR = "INSERT INTO tb_stock_record(sr_stock,sr_item,sr_item_quantity,sr_record_date,sr_record_type,sr_batch_uid)
										VALUES('$stock','$feed_id','$quantity','$recordDate','$recordTypeFeeding','$batch_uid')";
							$resultSR = mysqli_query($con,$sqlSR) or die(mysqli_error($con));

							$newBalance = $feedBalance - $quantity;
							$sqlFeedUpdate = "UPDATE tb_stock_balance SET sb_balance = '$newBalance' WHERE sb_stock_id = '$stock' AND sb_item = '$feed_id'";
							$resultFeedUpdate = mysqli_query($con,$sqlFeedUpdate);
						} else{
							echo "Not Enough Feed For Feed ID ".$feed_id;
						}
				


					}

				}
			}

			$sqlCode ="SELECT * FROM tb_category WHERE category_level = 'project_status' AND category_desc ='active'";
			$resultCode = mysqli_query($con,$sqlCode);

			$rowCode = mysqli_fetch_assoc($resultCode);
			$code = $rowCode['category_id'];

			$sqlUpdate ="UPDATE tb_project SET project_status = '$code' WHERE batch_uid = '$batch_uid'";
			$resultUpdate = mysqli_query($con,$sqlUpdate);


			break;
		
		case 'edit': {

			foreach ($recordArr as $record) {

				$house_id = $record['house_id'];
				$bird_death = $record['bird_death'];
				$bird_cull = $record['bird_cull'];
				$bird_catch = $record['bird_catch'];
				$feed = $record['feed'];
				$bird_id = $record['bird_id'];
				$bird_weight = $record['bird_weight'];
				$weight_event_id = $record['event_id'];

				if($bird_weight){
					$sqlProbe = "SELECT * FROM tb_weight WHERE weight_bird_id = '$bird_id'";
					$resultProbe = mysqli_query($con,$sqlProbe);
					if(mysqli_num_rows($resultProbe) > 0){
						$sqlUpdateWeight = "UPDATE tb_weight SET weight_data = '$bird_weight' WHERE weight_bird_id = '$bird_id'";
						$resultUpdateWeight = mysqli_query($con,$sqlUpdateWeight);
					}else{
						$sqlUpdateWeight = "INSERT tb_weight(weight_data,weight_bird_id,weight_event_id)
											VALUES('$bird_weight','$bird_id','$weight_event_id')";
						$resultUpdateWeight = mysqli_query($con,$sqlUpdateWeight);
					}
				}

				$balance = 0;
				$balance = $balance - ($bird_death + $bird_cull + $bird_catch);
					
				$sql = "UPDATE tb_bird SET bird_death = '$bird_death', bird_cull = '$bird_cull',bird_catch = '$bird_catch',bird_record_date = '$recordDate', bird_house_id = '$house_id', bird_batch_uid = '$batch_uid' WHERE bird_id = '$bird_id'";

				$result = mysqli_query($con,$sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error(), E_USER_ERROR);

				$feedArr = $record['feed'];

				var_dump($feedArr);

				foreach ($feedArr as $feed) {
					$sr_id = $feed['sr_id'];
					$feed_id = $feed['feed_id'];
					$quantity = $feed['quantity'];
					$stock = $feed['stock'];

					if($feed['sr_id']){

						echo $sr_id.'<br>';
						
						$sqlSROri = "SELECT * FROM tb_stock_record WHERE sr_id = '$sr_id'";
						$resultSROri = mysqli_query($con,$sqlSROri) or die(mysqli_error($con));
						$rowSROri = mysqli_fetch_assoc($resultSROri);
						$oriQuantity = $rowSROri['sr_item_quantity'];

						$sqlOldBalance = "SELECT * FROM tb_stock_balance WHERE sb_stock_id = '$stock' AND sb_item = '$feed_id'";
						$resultOldBalance = mysqli_query($con,$sqlOldBalance);
						$rowOldBalance = mysqli_fetch_assoc($resultOldBalance);
						$oldBalance = $rowOldBalance['sb_balance'];

						echo $oriQuantity.'<br>';
						echo $quantity;

						if($oriQuantity != $quantity){

							$newBalance = ($oldBalance + $oriQuantity) - $quantity ;

							if($newBalance > 0){
								
								$sqlFeedUpdate = "UPDATE tb_stock_balance SET sb_balance = '$newBalance' WHERE sb_stock_id = '$stock' AND sb_item = '$feed_id'";
								$resultFeedUpdate = mysqli_query($con,$sqlFeedUpdate);

								$sqlSR = "UPDATE tb_stock_record SET sr_stock = '$stock', sr_item_quantity = '$quantity' WHERE sr_id = '$sr_id' AND sr_item ='$feed_id'";
								$resultSR = mysqli_query($con,$sqlSR) or die(mysqli_error($con));
								} else{
									echo "Not Enough Feed For Feed ID ".$feed_id;
								}

						}





					} else{

						$feed_id = $feed['feed_id'];
						$quantity = $feed['quantity'];
						$stock = $feed['stock'];

						$sqlFeedBalance = "SELECT * FROM tb_stock_balance WHERE sb_stock_id = '$stock' AND sb_item = '$feed_id'";
						$resultFeedBalance = mysqli_query($con,$sqlFeedBalance) or die(mysqli_error($con));
						$rowFeedBalance = mysqli_fetch_assoc($resultFeedBalance);
						$feedBalance = $rowFeedBalance['sb_balance'];

						$feed_id = $feed['feed_id'];
						$quantity = $feed['quantity'];
						$stock = $feed['stock'];

						if(($feedBalance >= $quantity) && ($quantity != NULL)){
							$sqlSR = "INSERT INTO tb_stock_record(sr_stock,sr_item,sr_item_quantity,sr_record_date,sr_record_type,sr_batch_uid)
										VALUES('$stock','$feed_id','$quantity','$recordDate','$recordTypeFeeding','$batch_uid')";
							$resultSR = mysqli_query($con,$sqlSR) or die(mysqli_error($con));

							$newBalance = $feedBalance - $quantity;
							$sqlFeedUpdate = "UPDATE tb_stock_balance SET sb_balance = '$newBalance' WHERE sb_stock_id = '$stock' AND sb_item = '$feed_id'";
							$resultFeedUpdate = mysqli_query($con,$sqlFeedUpdate);
						}else{
							echo "Not Enough Feed For Feed ID ".$feed_id;
						}

					}
					

				}




			}

			$sqlUpdateBalance = "SELECT * FROM tb_bird WHERE bird_batch_uid = '$batch_uid' ORDER BY date(bird_record_date) ASC";
			$resultUpdateBalance = mysqli_query($con,$sqlUpdateBalance);

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

		default:
			# code...
			break;
	}



	$sqlUCoop = "SELECT DISTINCT bird_house_id FROM tb_bird"; 
	$resultUCoop = mysqli_query($con,$sqlUCoop);

	while($rowUCoop = mysqli_fetch_assoc($resultUCoop)){

		$uCoopId= $rowUCoop['bird_house_id'];

		$sqlLastUpdate = "	SELECT * FROM tb_bird
							JOIN tb_project ON tb_project.batch_uid = tb_bird.bird_batch_uid
							JOIN tb_category ON tb_project.project_status = tb_category.category_id
							WHERE tb_bird.bird_id = (SELECT MAX(bird_id) FROM tb_bird WHERE bird_house_id = '$uCoopId') AND tb_category.category_desc = 'active'";

		$resultLastUpdate = mysqli_query($con,$sqlLastUpdate);
		$rowLastUpdate = mysqli_fetch_assoc($resultLastUpdate);
		$usedCap = $rowLastUpdate['bird_balance'];




		$sqlUpdate ="UPDATE tb_coop SET coop_vacant_capacity = (tb_coop.coop_capacity - $usedCap) WHERE house_id = '$uCoopId'";
		$resultUpdate = mysqli_query($con,$sqlUpdate);


	}

	mysqli_close($con);

?>