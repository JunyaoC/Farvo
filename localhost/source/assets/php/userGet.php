<?php

	require('dbconnect.php');

    $sql = "SELECT user_email,user_name,user_id
            FROM tb_user";

    $result = mysqli_query($con,$sql);

    $userDateArr = array();

    while($row = mysqli_fetch_assoc($result)){

    	$userData = new \stdClass();

    	$userData->user_email = $row['user_email'];
    	$userData->user_name = $row['user_name'];
    	$userData->user_id = $row['user_id'];

    	array_push($userDateArr, $userData);
    }

    echo json_encode($userDateArr);
?>	