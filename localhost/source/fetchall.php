<?php
	
	$company_id = $_GET['company'];

	
?>

<!DOCTYPE html>
<html>
<head>
	<title>fecthall</title>
	<script src="assets/js/dashboardObject.js"></script>
	<script src="https://code.jquery.com/jquery-3.4.1.js"
			  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
			  crossorigin="anonymous">
	</script>
</head>
<body>

	<h3>123</h3>



<script type="text/javascript">
	
	if(window._dashboard == null){

		window._dashboard = new dashboard('<?php echo $company_id ?>');	


	}


</script>

</body>
</html>