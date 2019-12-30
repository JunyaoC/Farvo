<?php
	
	require('dbconnect.php');

	$user_id = $_GET['user_id'];

	if($user_id == 0){
		$sqlFetchCompany = "SELECT * FROM tb_company";
		$resultFetchCompany = mysqli_query($con,$sqlFetchCompany);

		$companyArr = array();
		while($rowFetchCompany = mysqli_fetch_assoc($resultFetchCompany)){

			$newCompany = new \stdClass();

			$newCompany->company_id = $rowFetchCompany['company_id'];
			$newCompany->company_name = $rowFetchCompany['company_name'];
			$newCompany->company_address = $rowFetchCompany['company_address'];
			$newCompany->company_ssm = $rowFetchCompany['company_ssm'];
			$newCompany->company_joinDt = $rowFetchCompany['company_joinDt'];
			$newCompany->company_cat = $rowFetchCompany['company_cat'];
			$newCompany->company_card = '

				<div class="companyCol col-md-3 col-sm-12" style="margin:1rem 0;display:flex;justify-content:center;padding:0;">
					<div class="card" style="width:90%;">
					  <div style="height: 13rem;background:#DDDDDD">


					  	<div class="mapouter"><div class="gmap_canvas"><iframe width="100%" height="100%" id="gmap_canvas" src="https://maps.google.com/maps?q='.urlencode($newCompany->company_address).'a&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.embedgooglemap.net">embedgooglemap.net</a></div><style>.mapouter{position:relative;text-align:right;height:100%;width:100%;}.gmap_canvas {overflow:hidden;background:none!important;height:100%;width:100%;}</style></div>


					  </div>
					  <div class="card-body">
		  				<h5 class="card-title text-center" style="margin:0;">'.$newCompany->company_name.'</h5>
					  	<div class="text-center" style="background:#FFEE7C;margin:0.5rem -1.25rem 0.5rem -1.25rem;padding:0.5rem">
				    		<a href="companyDashboardFrame.php?company='.$newCompany->company_id.'"><p style="margin:0;font-family:Cabin;font-weight:900;font-size:1.5rem;">View Company</p></a>
				  		</div>
				  		<div class="text-center" style="margin:0 -1rem;">
				    		<a href="#" style="margin:0;" class="editCompanyButton" company_id="'.$newCompany->company_id.'">Edit Company</a>
				  		</div>

					    
					    
					  </div>
					</div>
				</div>

			';

			if( $newCompany->company_id > 0){
				array_push($companyArr, $newCompany);
			}

			

		}


	}else{
		$sqlFetchCompany = "SELECT * FROM tb_company JOIN tb_access ON tb_company.company_id = tb_access.access_company_id WHERE tb_access.access_user_id = '$user_id'";
		$resultFetchCompany = mysqli_query($con,$sqlFetchCompany);

		$companyArr = array();
		while($rowFetchCompany = mysqli_fetch_assoc($resultFetchCompany)){

			$newCompany = new \stdClass();

			$newCompany->company_id = $rowFetchCompany['company_id'];
			$newCompany->company_name = $rowFetchCompany['company_name'];
			$newCompany->company_address = $rowFetchCompany['company_address'];
			$newCompany->company_ssm = $rowFetchCompany['company_ssm'];
			$newCompany->company_joinDt = $rowFetchCompany['company_joinDt'];
			$newCompany->company_cat = $rowFetchCompany['company_cat'];

			$newCompany->access_level = $rowFetchCompany['access_level'];
			$newCompany->company_card = '

				<div class="companyCol col-md-3 col-sm-12" style="margin:1rem 0;display:flex;justify-content:center;padding:0;">
					<div class="card" style="width:90%;">
					  <div style="height: 13rem;background:#DDDDDD">


					  	<div class="mapouter"><div class="gmap_canvas"><iframe width="100%" height="100%" id="gmap_canvas" src="https://maps.google.com/maps?q='.urlencode($newCompany->company_address).'a&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.embedgooglemap.net">embedgooglemap.net</a></div><style>.mapouter{position:relative;text-align:right;height:100%;width:100%;}.gmap_canvas {overflow:hidden;background:none!important;height:100%;width:100%;}</style></div>


					  </div>
					  <div class="card-body">
		  				<h5 class="card-title text-center" style="margin:0;">'.$newCompany->company_name.'</h5>
					  	<div class="text-center" style="background:#FFEE7C;margin:0.5rem -1.25rem 0.5rem -1.25rem;padding:0.5rem">
				    		<a href="companyDashboardFrame.php?company='.$newCompany->company_id.'"><p style="margin:0;font-family:Cabin;font-weight:900;font-size:1.5rem;">View Company</p></a>
				  		</div>
				  		<div class="text-center" style="margin:0 -1rem;">
				    		
				  		</div>

					    
					    
					  </div>
					</div>
				</div>

			';

			if( $newCompany->company_id > 0){
				array_push($companyArr, $newCompany);
			}

			

		}


	}


	echo json_encode($companyArr);
	mysqli_close($con);
?>
