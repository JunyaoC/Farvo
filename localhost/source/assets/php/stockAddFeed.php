<?php
	
	require('dbconnect.php');

	$feedData  = $_POST['feedData'];
	$sb_stock_id  = $_POST['sb_stock_id'];
	$sr_record_type  = $_POST['sr_record_type'];
	$cost_category = $_POST['cost_category'];
	$cost_note = $_POST['cost_note'];
	$cost_amount = $_POST['cost_amount'];
	$cost_cycle_id = $_POST['cost_cycle_id'];
	
	date_default_timezone_set("Asia/Kuala_Lumpur");

	foreach ($feedData as $feed) {

		$sb_item = $feed['sb_item'];
		$quantity = $feed['quantity'];
			
		$sqlGetCurrentBalance = "SELECT * FROM tb_stock_balance WHERE sb_item ='$sb_item' AND sb_stock_id = '$sb_stock_id'";
		$resultGetCurrentBalance = mysqli_query($con,$sqlGetCurrentBalance) or die(mysqli_error($con));
		$rowGetCurrentBalance = mysqli_fetch_assoc($resultGetCurrentBalance);

		if($rowGetCurrentBalance['sb_balance'] > 0){
			$newBalance = $rowGetCurrentBalance['sb_balance'] + $quantity;

			$sqlUpdate ="UPDATE tb_stock_balance SET sb_balance = '$newBalance' WHERE sb_item ='$sb_item' AND sb_stock_id = '$sb_stock_id'";
			$resultUpdate = mysqli_query($con,$sqlUpdate);
		}else{
			$sqlInsert ="INSERT INTO tb_stock_balance(sb_stock_id,sb_item,sb_balance) VALUES ('$sb_stock_id','$sb_item','$quantity')";
			$resultInsert = mysqli_query($con,$sqlInsert);
		}


		$sqlInsert ="INSERT INTO tb_stock_record(sr_stock, sr_item, sr_item_quantity, sr_record_date, sr_record_type,sr_batch_uid) VALUES ('$sb_stock_id','$sb_item','$quantity',curdate(),'$sr_record_type','')";
		$resultInsert = mysqli_query($con,$sqlInsert);


	}

	$sqlCost = "INSERT INTO tb_cost(cost_date,cost_category,cost_amount,cost_note,cost_cycle_id)
			VALUES(curdate(),'$cost_category','$cost_amount','$cost_note','$cost_cycle_id')";
	$resultCost = mysqli_query($con,$sqlCost);

	mysqli_close($con);
?>