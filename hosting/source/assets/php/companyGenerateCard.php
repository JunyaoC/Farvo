<?php

	$company_name = $_GET['company_name'];
	$company_id = $_GET['company_id'];
	$company_address = $_GET['company_address'];
	$company_ssm = $_GET['company_ssm'];
	$company_joinDt= $_GET['company_joinDt'];
	$company_cat = $_GET['company_cat'];
	$access_level = $_GET['access_level'];

?>


<div class="card" style="width: 18rem;height: 29rem;">
  <div class="card-body">
    <h5 class="card-title"><?php echo $company_name; ?></h5>
    <p class="card-text"><?php echo $company_address; ?></p>
    <a href="#" class="btn btn-primary">View</a>
  </div>
</div>