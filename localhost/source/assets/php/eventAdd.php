<?php

	require('dbconnect.php');

	$event_type = $_POST["event_type"];
	$event_date = $_POST["event_date"];
	$event_batch_uid = $_POST["event_batch_uid"];
	$event_note = $_POST["event_note"];
	$event_note = addslashes($event_note);
	$event_date = date('Y-m-d', strtotime($event_date));

	$sql = "INSERT INTO tb_event(event_type,event_date,event_batch_uid,event_note,event_state)
			VALUES('$event_type','$event_date','$event_batch_uid','$event_note','1')";

	$result = mysqli_query($con,$sql) or die(mysqli_error($con));
	mysqli_close($con);
?>