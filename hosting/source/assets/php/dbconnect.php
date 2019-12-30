<?php

	$dbhost = "localhost";		////	kindly update 
	$dbuser = "dbusername";		////	these information
	$dbpass = "dbpassword";		////	accroding to your database server
	$db = "farvodb";

    $con = mysqli_connect($dbhost,$dbuser,$dbpass,$db);

	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
	}


?>