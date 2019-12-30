<?php

	$cycle_id = $_GET['cycle_id'];


?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cabin">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/material-icons.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
  	<script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-colorschemes"></script>
</head>
<body>


	<style type="text/css">

		html{
			font-family: Cabin, sans-serif;
			background: #DEDEDE;
		}

		.mainWrapper{

		}

		.show{

		}

		.sidePanel{
			position: fixed;
			left: 0;
			width: 300px;
			background:white;
			height: 100vh;
			transition: 1s;
		}

		.mainContent{
			z-index: 1;
			position: relative;
			left: 300px;
			width: 100%;
			height: auto;
			padding: 1rem;
			background: #DEDEDE;
		}

		.mainContentCover{
			position: absolute;
			top: 0;
			z-index: -100;
			background: rgba(0,0,0,0.8);
			width: 100vw;
			height: 100vh;
			transition: 1s;
		}

		.statsCard{
			height: 100%;
			width: 100%;
			padding: 1rem;
		}

		h1,h2,h3,h4,h5,h6{
			font-family: Cabin, sans-serif;
			font-weight: 900;
		}

		.colDeath{
			background: rgba(255, 153, 153,0.5);
		}

		.colCull{
			background: rgba(255, 243, 153,0.5);
		}

		.colCatch{
			background: rgba(204, 255, 153,0.5);
		}

		@media only screen and (max-width: 600px) {

			.mainWrapper{
				height: 100vh;
			}

			.sidePanel{
				z-index: 100;
				position: absolute;
				left: -300px;
				width: 300px;
			}

			.mainContent{
				position: relative;
				top:0;
				left: 0;
				height: 100vh;
				background: #DEDEDE;
				padding: 1rem;
				overflow-y: scroll;
				
			}

		}

	</style>

	<div class="mainWrapper">
		<div class="sidePanel">
			<div class="container" style="padding:3rem 1rem;">
				<h6>Cycle Report</h6>
				<h2>Cycle Name</h2>
				<p>in Farm Name</p>
			</div>
			<div class="container">
				<p style="display: inline;">Prepared by </p><h6 style="display: inline;">FARVO</h6>
			</div>
			<div class="container" style="padding: 3rem 1rem;">
				
				<h3>Contents</h3>
				<ul>
					<li><a href="#profit&loss">Profit & Loss</a></li>
					<li><a href="#cycle_performance">Cycle Performance</a></li>
				</ul>


			</div>
			<div class="container" style="padding: 3rem 1rem;">
				
				<h3>Batch Card</h3>
				<ul id="batchCardList">
				</ul>


			</div>
		</div>
		<div class="mainContentCover"></div>
		<div class="mainContent">

			<div id="navBar" class="container" style="background-color: white; margin: -1rem -1rem 1rem -1rem;width: 100vw;">
				<div class="row d-flex justify-content-between">
					<div class="col d-flex justify-content-center align-items-center">
						<h2 style="margin:0;">Report</h2>
					</div>
					<div class="col d-flex justify-content-center align-items-center">
						<button class="btn btn-outline-primary btn-sm toggleSide" data-toggle="tooltip" data-placement="top" title="Show Farms"><i class="fas fa-bars"></i></button>
					</div>
				</div>
			</div>

			<div id="profit&loss">

				<h3>Profit & Loss</h3>

				<div class="row">
					
					<div class="col-sm-6 col-md-3" style="padding: 0.5rem;">
						
						<div class="statsCard">
							<h5>Gross Profit</h5>
							<h2 id="grossPLDisplay">RM -</h2>
							<p style="font-size: 0.7rem;">(Total Bird Weight X Price per KG) - (DOC Cost + Feed Consumed + Medicine & Supplement)</p>
							
						</div>

					</div>

					<div class="col-sm-6 col-md-3" style="padding: 0.5rem;">
						
						<div class="statsCard">
							<h5>Gross Profit/Loss per Bird</h5>
							<h2 id="gplBirdDisplay">RM -</h2>
							<p style="font-size: 0.7rem;">(Total Bird Weight X Price per KG) - (DOC Cost + Feed Consumed + Medicine & Supplement)</p>
							
						</div>

					</div>	

					<div class="col-sm-6 col-md-3" style="padding: 0.5rem;">
						
						<div class="statsCard">
							<h5>Net Profit</h5>
							<h2 id="netPLDisplay">RM -</h2>
							<p style="font-size: 0.7rem;">(Total Bird Weight X Price per KG) - (DOC Cost + Feed Consumed + Medicine & Supplement)</p>
							
						</div>

					</div>	

					<div class="col-sm-6 col-md-3" style="padding: 0.5rem;">
						
						<div class="statsCard">
							<h5>Net Profit/Loss per Bird</h5>
							<h2 id="nplBirdDisplay">RM -</h2>
							<p style="font-size: 0.7rem;">(Total Bird Weight X Price per KG) - (DOC Cost + Feed Consumed + Medicine & Supplement)</p>
							
						</div>

					</div>				

				</div>

				<div class="row">
					
					<div class="col-12" style="padding: 1rem;">
						
						<div class="statsCard shadow" style="background: white;border-radius: 0.3rem;">

							<h3>P&L Statement</h3>
							
							<table class="table table-sm">
							  <thead>
							    <tr>
							      <th scope="col" style="width: 60%;"></th>
							      <th scope="col" style="width: 20%;">RM</th>
							      <th scope="col" style="width: 20%;">RM</th>
							    </tr>
							  </thead>
							  <tbody id="costTableBody">
							  	
							  </tbody>
							</table>

						</div>
					</div>
				</div>
				

			</div>

			<div id="cycle_performance" style="margin-top: 3rem;height: 100vh;">
				<h3 style="margin-bottom: 3rem;">Cycle Performance</h3>

				<div class="row">
						
					<div class="col-12" style="padding: 1rem; ">
						

						<div>

							<h3>Bird Record</h3>

							<div class="container text-center">
								<div class="row">
									<div class="col-4 text-center">
										<h4>Death</h4>
										<h6>Total</h6>
										<h2 id="overallBirdDeath">-</h2>
									</div>
									<div class="col-4 text-center">
										<h4>Cull</h4>
										<h6>Total</h6>
										<h2 id="overallBirdCull">-</h2>
									</div>
									<div class="col-4 text-center">
										<h4>Catch</h4>
										<h6>Total</h6>
										<h2 id="overallBirdCatch">-</h2>
									</div>
									
								</div>
								
							</div>

							<div class="table-responsive">
								
								<table class="table table-sm table-hover" style="background: white;">
									<thead>
										<tr>
											<th rowspan="2" class="text-center" style="vertical-align: middle;">House</th>
											<th colspan="3" class="text-center colDeath" scope="colgroup">Death</th>
											<th colspan="3" class="text-center colCull" scope="colgroup">Cull</th>
											<th colspan="3" class="text-center colCatch" scope="colgroup">Catch</th>
											<th rowspan="2" class="text-center" style="vertical-align: middle;">Bal.</th>
											<th rowspan="2" class="text-center" style="vertical-align: middle;">FCR</th>
											<th rowspan="2" class="text-center" style="vertical-align: middle;">PI</th>
										</tr>
										<tr>
											<th scope="col" class="colDeath">Sum</th>
											
											<th scope="col" class="colDeath">Max</th>
											<th scope="col" class="colDeath">Min</th>
											<th scope="col" class="colCull">Sum</th>
											
											<th scope="col" class="colCull">Max</th>
											<th scope="col" class="colCull">Min</th>
											<th scope="col" class="colCatch">Sum</th>
											
											<th scope="col" class="colCatch">Max</th>
											<th scope="col" class="colCatch">Min</th>
											
										</tr>									
									</thead>
									<tbody id="birdDataTable">
																				
									</tbody>

								</table>

							</div>




						</div>

						
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						<div>
							<h3>Feed Record</h3>

							<div class="container text-center">
								<div class="row">
									<div class="col-4 text-center">
										<h4>Starter</h4>
										<h6>Total</h6>
										<h2 id="overallStarter">-</h2>
									</div>
									<div class="col-4 text-center">
										<h4>Grower</h4>
										<h6>Total</h6>
										<h2 id="overallGrower">-</h2>
									</div>
									<div class="col-4 text-center">
										<h4>Crumble</h4>
										<h6>Total</h6>
										<h2 id="overallCrumble">-</h2>
									</div>
									
								</div>
								
							</div>

							<div class="table-responsive">
								<table class="table table-sm table-hover" style="background: white;">
									<thead>
										<tr>
											<td rowspan="2"></td>
											<th colspan="3" class="text-center colDeath" scope="colgroup">Starter</th>
											<th colspan="3" class="text-center colCull" scope="colgroup">Grower</th>
											<th colspan="3" class="text-center colCatch" scope="colgroup">Crumble</th>
										</tr>
										<tr>
											<th scope="col" class="colDeath">Sum</th>											
											<th scope="col" class="colDeath">Max</th>
											<th scope="col" class="colDeath">Min</th>
											<th scope="col" class="colCull">Sum</th>
											
											<th scope="col" class="colCull">Max</th>
											<th scope="col" class="colCull">Min</th>
											<th scope="col" class="colCatch">Sum</th>
											
											<th scope="col" class="colCatch">Max</th>
											<th scope="col" class="colCatch">Min</th>
											
										</tr>									
									</thead>
									<tbody id="feedTableBody">
										<!-- <tr>
											<th scope="row">House 1</th>
											<td class="colDeath">600</td>
											<td class="colDeath">300</td>
											<td class="colDeath">400</td>
											<td class="colCull">500</td>
											<td class="colCull">600</td>
											<td class="colCull">300</td>
											<td class="colCatch">400</td>
											<td class="colCatch">500</td>
											<td class="colCatch">600</td>
			
										</tr> -->
										

										
									</tbody>

								</table>
								

							</div>



						</div>
					</div>	
					
				</div>




			</div>
			


		</div>




	</div>

	<script type="text/javascript">

		if(typeof(window.category) != 'function'){

			updateCategory();

		}
		

		var viewportWidth = $(window).width();
		if(viewportWidth < 600){
			$('.mainContent').css('width','100%');
		}else{
			$('#navBar').remove();
			$('.mainContent').width(viewportWidth - 300 - 30);
		}

		var cycle_id = '<?php echo $cycle_id ?>';

		$.ajax({
			url:'assets/php/getReportData.php',
			data: {'cycle_id':cycle_id},
			method: 'GET'
		}).done(function(data){
			var response = JSON.parse(data);
			generateAnalytics(response);
		})


		function generateAnalytics(response){

			var incomeTable = document.createElement('DIV');
			var costList = {};

			var allCost = response.cycle_cost;
			var batchList = response.batch;
			var houseData = {};
			var totalWeight = 0;
            var batchObj = {};

            var allProfit = 0;
            var allCatch = 0;
            

            var cycleInitDate = new Date(response.cycle_init_date);

            var cycleEndDate = response.cycle_end_date;
            if(cycleEndDate.length == ""){
            	cycleEndDate = new Date();
            }else{
            	cycleEndDate = new Date(cycleEndDate);            	
            }

            console.log(cycleInitDate,cycleEndDate);

            var cycleTimeDiff = Math.abs(cycleEndDate.getTime() - cycleInitDate.getTime());
	        var cycleDiffDays = Math.ceil(cycleTimeDiff / (1000 * 3600 * 24));
	        var cycleDuration = cycleDiffDays + 1;

		    for(var j=0;j<batchList.length;j++){

		        var date1 = new Date(batchList[j].batch_date);
		        var endDate = new Date(batchList[j].batch_date);

		        console.log(batchList[j]);

		        var batchRecord = batchList[j].batch_record;

		        $('#batchCardList').append('<li><a href="#" class="batchCardTrigger" batch_uid="'+batchList[j].batch_uid+'">'+batchList[j].batch_name+'</a></li>')

		        for(var k=0;k<batchRecord.length;k++){

		            var date2 = new Date(batchRecord[k].bird_record_date);

		            if(date2 > endDate){
		                endDate = date2;
		            }

		            if(typeof(houseData[batchRecord[k].bird_house_id]) == 'undefined'){
		            	houseData[batchRecord[k].bird_house_id] = {
		            		bird_amount: null,
		            		weight: null
		            	}
		            }

		            if(typeof(batchRecord[k].bird_weight) != 'undefined'){

		                houseData[batchRecord[k].bird_house_id] = {
		                    bird_amount: batchRecord[k].bird_balance,
		                    weight: batchRecord[k].bird_weight
		                }

		            }else{
		                houseData[batchRecord[k].bird_house_id].bird_amount = batchRecord[k].bird_balance
		            }

	             	if(typeof(batchRecord[k].bird_profit) != 'undefined'){
		            	allProfit = allProfit + Number(batchRecord[k].bird_profit);
	             	}

	             	allCatch = allCatch + Number(batchRecord[k].bird_catch);

		        }

		        var batchStockRecord = batchList[j].batch_stock_record;

		        var feedObj = {};

		        for(var k=0;k<batchStockRecord.length;k++){

		            if(typeof(houseData[batchStockRecord[k].sr_house_id].total_feed) == 'undefined'){
		                houseData[batchStockRecord[k].sr_house_id].total_feed = Number(batchStockRecord[k].sr_item_quantity);
		            }else{
		                houseData[batchStockRecord[k].sr_house_id].total_feed = houseData[batchStockRecord[k].sr_house_id].total_feed + Number(batchStockRecord[k].sr_item_quantity);
		            }

		            if(typeof(feedObj[batchStockRecord[k].sr_item]) == 'undefined'){
		                feedObj[batchStockRecord[k].sr_item] = Number(batchStockRecord[k].sr_item_quantity);
		            }else{
		                feedObj[batchStockRecord[k].sr_item] = feedObj[batchStockRecord[k].sr_item] + Number(batchStockRecord[k].sr_item_quantity);
		            }

		        }

		        var houseCount = Object.keys(houseData).length;
		        var totalInit = 0;

		        for(var l=0;l<houseCount;l++){
		            houseData[batchRecord[l].bird_house_id]['initBird'] = Number(batchRecord[l].bird_balance);
		            totalInit = totalInit + Number(batchRecord[l].bird_balance);
		        }



		        var thisBatch = {};

		        for(var obj in houseData){

		            thisBatch[obj] = houseData[obj];

		        }

		        houseData = {};
		        batchObj[batchList[j].batch_uid] = thisBatch;


		        var timeDiff = Math.abs(endDate.getTime() - date1.getTime());
		        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
		        var totalDays = diffDays + 1;

		        batchObj[batchList[j].batch_uid]['days'] = totalDays;
		        batchObj[batchList[j].batch_uid]['totalInit'] = totalInit;
		        batchObj[batchList[j].batch_uid]['feed'] = feedObj;

		    }

		    console.log(batchObj);

            for(var obj in batchObj){

                var totalBird = 0;
                var totalFeed = 0;
                var totalWeight = 0;

                var weightExist = true;

                for(var house in batchObj[obj]){

                    if(house != 'days' && house != 'totalInit'){
                        if(batchObj[obj][house].weight && batchObj[obj][house].total_feed){
                            var fcr = (batchObj[obj][house].bird_amount * batchObj[obj][house].weight) / ( 50* batchObj[obj][house].total_feed);
                            batchObj[obj][house]['fcr'] = fcr;

                            totalBird = Number(batchObj[obj][house].bird_amount) + totalBird;
                            totalFeed = Number(batchObj[obj][house].total_feed) + totalFeed;
                            totalWeight = Number(batchObj[obj][house].weight) + totalWeight;

                            var performanceIndex = (batchObj[obj][house].weight * (batchObj[obj][house].bird_amount / batchObj[obj][house].initBird)) / (Number(batchObj[obj]['days']) * fcr) * 100;
                            batchObj[obj][house]['pi'] = performanceIndex;

                        }else{
                            weightExist = false;
                        }
                    }

                    if(weightExist){

                        var houseCount = 0;
                        
                        for(var l=0;l<Object.keys(batchObj[obj]).length;l++){
                            if(Object.keys(batchObj[obj])[l] != 'days' && Object.keys(batchObj[obj])[l] != 'fcr' && Object.keys(batchObj[obj])[l] != 'totalInit' && Object.keys(batchObj[obj])[l] != 'pi'){
                                houseCount = houseCount + 1;
                            }
                        }

                        var averageWeight = totalWeight / houseCount;

                        var batchFCR = (totalBird * averageWeight) / ( 50* totalFeed);
                        batchObj[obj]['fcr'] = batchFCR;

                        var performanceIndex = (averageWeight * (totalBird / batchObj[obj].totalInit)) / (Number(batchObj[obj]['days']) * Number(batchObj[obj]['fcr'])) * 100;
                            batchObj[obj]['pi'] = performanceIndex;


                    }
                }

            }

            var totalCost = 0;

            var totalWeight = 0;
            var totalWeightProfitPerBatch = 0;
            var totalFeed = 0;
            var totalGPLCost = 0;
            var totalBirdBalance = 0;

            var cycleCostArr = allCost;

            for(var j=0;j<cycleCostArr.length;j++){ ////need to make feed into 2 category - consumption and feed
                if(getCategoryDesc('cost',cycleCostArr[j].cost_category) == 'day 0 chick' || getCategoryDesc('cost',cycleCostArr[j].cost_category) == 'medication & supplements'){
                    totalGPLCost = totalGPLCost + Number(cycleCostArr[j].cost_amount);
                }

                if(typeof(costList[getCategoryDesc('cost',cycleCostArr[j].cost_category)]) == 'undefined'){
                	costList[getCategoryDesc('cost',cycleCostArr[j].cost_category)] = Number(cycleCostArr[j].cost_amount);
                }else{
                	costList[getCategoryDesc('cost',cycleCostArr[j].cost_category)] = Number(cycleCostArr[j].cost_amount) + costList[getCategoryDesc('cost',cycleCostArr[j].cost_category)];
                }

                totalCost = totalCost + Number(cycleCostArr[j].cost_amount);

            }

            var currentBatch = batchList;

            for(var i=0;i<currentBatch.length;i++){

                var batchAnalytics = batchObj[currentBatch[i].batch_uid];
                var batchType = currentBatch[i].batch_type;

                for(var keys in batchAnalytics){

                    if(keys != 'days' && keys != 'totalInit' && keys != 'fcr' && keys != 'pi' && keys != 'feed'){

                        totalWeight = totalWeight + (Number(batchAnalytics[keys].weight) * Number(batchAnalytics[keys].bird_amount));

                        totalBirdBalance = totalBirdBalance + (Number(batchAnalytics[keys].bird_amount));

                        for(var j=0;j<window.category.length;j++){

                            if(window.category[j].category_level == 'batch_price' && window.category[j].category_code == batchType){
                                totalWeightProfitPerBatch = totalWeightProfitPerBatch + (Number(window.category[j].category_desc) * totalWeight);
                            }

                        }

                    }

                    if(keys == 'feed'){

                        for(var feed in batchAnalytics[keys]){

                            for(var j=0;j<window.category.length;j++){

                                if(window.category[j].category_level == 'feed_price' && window.category[j].category_code == feed){

                                    totalGPLCost = totalGPLCost + (Number(window.category[j].category_desc) * Number(batchAnalytics[keys][feed]));

                                }
                            }

                        }
                    }

                }


            }

            allProfit = allProfit.toFixed(2);

            var gpl = allProfit - totalGPLCost;
            var npl = allProfit - totalCost;


            $('#grossPLDisplay').text(negativeBracket(gpl));
            $('#netPLDisplay').text(negativeBracket(npl));
            $('#gplBirdDisplay').text(negativeBracket(gpl/allCatch));
            $('#nplBirdDisplay').text(negativeBracket(npl/allCatch));

            $(incomeTable).append('<tr> <th scope="row">Income</th> <td></td> <td></td> </tr> <tr> <th scope="row">Profit from Bird harvest</th> <td>'+allProfit+'</td> <td>&nbsp;</td> </tr> <tr> <th scope="row">&nbsp;</th> <td>&nbsp;</td> <td>'+allProfit+'</td> </tr>');

            $('#costTableBody').append($(incomeTable).html());
            $('#costTableBody').append('<tr> <td colspan="3">&nbsp;</td> </tr>');
            $('#costTableBody').append('<tr> <th scope="row">Expense</th> <td></td> <td></td> </tr> <tr>');   

            var totalTableCost = 0;          

            for(var obj in costList){

            	$('#costTableBody').append('<tr> <th scope="row">'+obj+'</th> <td>'+costList[obj]+'</td> <td>&nbsp;</td> </tr>');
            	totalTableCost = totalTableCost + Number(costList[obj]);

            }

            $('#costTableBody').append('<tr> <th scope="row">&nbsp;</th> <td>&nbsp;</td> <td>'+totalTableCost+'</td> </tr>');    
            $('#costTableBody').append('<tr> <td colspan="3">&nbsp;</td> </tr>');

            $('#costTableBody').append('<tr> <th scope="row">Profit/Loss</th> <td>&nbsp;</td> <td>'+(allProfit - totalTableCost)+'</td> </tr>');   
            

            console.log(batchObj);

            var houseDataObj = {};
            var feedDataObj = {};

            for(var i=0;i<batchList.length;i++){

            	var batchRecordArr = batchList[i].batch_record;

            	var house_id_arr = [];

				for(var j=0;j<batchRecordArr.length;j++){
				    if(house_id_arr.indexOf(batchRecordArr[j].bird_house_id) == -1){
				    	house_id_arr.push(batchRecordArr[j].bird_house_id);				        
				    }
				}

				console.log(house_id_arr);
            	

            	for(var j=house_id_arr.length;j<batchRecordArr.length;j++){

            		feedDataObj[batchRecordArr[j].bird_house_id] = {};

            		if(typeof(houseDataObj[batchRecordArr[j].bird_house_id]) == 'undefined'){
            			houseDataObj[batchRecordArr[j].bird_house_id] = {
            				bird_death : {
            					sum: Number(batchRecordArr[j].bird_death),
            					min: Number(batchRecordArr[j].bird_death),
            					max: Number(batchRecordArr[j].bird_death)
            				},
            				bird_cull : {
            					sum: Number(batchRecordArr[j].bird_cull),
            					min: Number(batchRecordArr[j].bird_cull),
            					max: Number(batchRecordArr[j].bird_cull)
            				},
            				bird_catch : {
            					sum: Number(batchRecordArr[j].bird_catch),
            					min: Number(batchRecordArr[j].bird_catch),
            					max: Number(batchRecordArr[j].bird_catch)
            				}

            			}
            		}else{

            			houseDataObj[batchRecordArr[j].bird_house_id].bird_death.sum = houseDataObj[batchRecordArr[j].bird_house_id].bird_death.sum + Number(batchRecordArr[j].bird_death);
            			if(batchRecordArr[j].bird_death < houseDataObj[batchRecordArr[j].bird_house_id].bird_death.min){
            				houseDataObj[batchRecordArr[j].bird_house_id].bird_death.min = Number(batchRecordArr[j].bird_death);
            			}
            			if(batchRecordArr[j].bird_death > houseDataObj[batchRecordArr[j].bird_house_id].bird_death.max){
            				houseDataObj[batchRecordArr[j].bird_house_id].bird_death.max = Number(batchRecordArr[j].bird_death);
            			}

            			houseDataObj[batchRecordArr[j].bird_house_id].bird_cull.sum = houseDataObj[batchRecordArr[j].bird_house_id].bird_cull.sum + Number(batchRecordArr[j].bird_cull);
            			if(batchRecordArr[j].bird_cull < houseDataObj[batchRecordArr[j].bird_house_id].bird_cull.min){
            				houseDataObj[batchRecordArr[j].bird_house_id].bird_cull.min = Number(batchRecordArr[j].bird_cull);
            			}
            			if(batchRecordArr[j].bird_cull > houseDataObj[batchRecordArr[j].bird_house_id].bird_cull.max){
            				houseDataObj[batchRecordArr[j].bird_house_id].bird_cull.max = Number(batchRecordArr[j].bird_cull);
            			}

            			houseDataObj[batchRecordArr[j].bird_house_id].bird_catch.sum = houseDataObj[batchRecordArr[j].bird_house_id].bird_catch.sum + Number(batchRecordArr[j].bird_catch);
            			if(batchRecordArr[j].bird_catch < houseDataObj[batchRecordArr[j].bird_house_id].bird_catch.min){
            				houseDataObj[batchRecordArr[j].bird_house_id].bird_catch.min = Number(batchRecordArr[j].bird_catch);
            			}
            			if(batchRecordArr[j].bird_catch > houseDataObj[batchRecordArr[j].bird_house_id].bird_catch.max){
            				houseDataObj[batchRecordArr[j].bird_house_id].bird_catch.max = Number(batchRecordArr[j].bird_catch);
            			}
            		}


            	}

            }

            var totalDeath = 0;
            var totalCull = 0;
            var totalCatch = 0;

            for(var obj in houseDataObj){

            	var totalBird = 0;
            	var totalFeed = 0;
            	var totalWeight = 0;
            	var totalInit = 0;

            	for(var batch in batchObj){

            		for(var house in batchObj[batch]){

            			if(house == obj){

            				totalBird = totalBird + Number(batchObj[batch][house].bird_amount);
            				totalFeed = totalFeed + Number(batchObj[batch][house].total_feed);
            				totalInit = totalInit + Number(batchObj[batch][house].initBird);
            				totalWeight = totalWeight + (Number(batchObj[batch][house].bird_amount) * Number(batchObj[batch][house].weight));


            			}
            		}
            	}


            	var fcrHouse = totalWeight / (50*totalFeed);

            	var avgWeight = totalWeight / totalBird;
            	console.log(avgWeight,totalBird,totalInit,cycleDuration,fcrHouse);
            	var piHouse = ((avgWeight * (totalBird / totalInit)) / (cycleDuration * fcrHouse)) * 100;

            	totalDeath = totalDeath + houseDataObj[obj].bird_death.sum;
            	totalCull = totalCull + houseDataObj[obj].bird_cull.sum;
            	totalCatch = totalCatch + houseDataObj[obj].bird_catch.sum;

            	$('#birdDataTable').append('<tr> <th scope="row">'+obj+'</th> <td class="colDeath">'+houseDataObj[obj].bird_death.sum+'</td> <td class="colDeath">'+houseDataObj[obj].bird_death.max+'</td> <td class="colDeath">'+houseDataObj[obj].bird_death.min+'</td> <td class="colCull">'+houseDataObj[obj].bird_cull.sum+'</td> <td class="colCull">'+houseDataObj[obj].bird_cull.max+'</td> <td class="colCull">'+houseDataObj[obj].bird_cull.min+'</td> <td class="colCatch">'+houseDataObj[obj].bird_catch.sum+'</td> <td class="colCatch">'+houseDataObj[obj].bird_catch.max+'</td> <td class="colCatch">'+houseDataObj[obj].bird_catch.min+'</td> <td>'+totalBird+'</td> <td>'+fcrHouse.toFixed(2)+'</td> <td>'+piHouse.toFixed(2)+'</td> </tr>')
            }

            console.log(houseDataObj);
         	console.log(batchObj);
         	console.log(batchList);

         	$('#overallBirdDeath').text(totalDeath);
         	$('#overallBirdCull').text(totalCull);
         	$('#overallBirdCatch').text(totalCatch);

         	

         	for(var i=0;i<batchList.length;i++){

         		var batchStockArr = batchList[i].batch_stock_record;

         		for(var j=0;j<batchStockArr.length;j++){

         			if(typeof(feedDataObj[batchStockArr[j].sr_house_id][batchStockArr[j].sr_item]) == 'undefined'){

         				feedDataObj[batchStockArr[j].sr_house_id][batchStockArr[j].sr_item] ={
         					sum: Number(batchStockArr[j].sr_item_quantity),
         					min: Number(batchStockArr[j].sr_item_quantity),
         					max: Number(batchStockArr[j].sr_item_quantity)
         				}

         			}else{
         				feedDataObj[batchStockArr[j].sr_house_id][batchStockArr[j].sr_item].sum = feedDataObj[batchStockArr[j].sr_house_id][batchStockArr[j].sr_item].sum + Number(batchStockArr[j].sr_item_quantity);

         				if( Number(batchStockArr[j].sr_item_quantity) < feedDataObj[batchStockArr[j].sr_house_id][batchStockArr[j].sr_item].min){
         					feedDataObj[batchStockArr[j].sr_house_id][batchStockArr[j].sr_item].min = Number(batchStockArr[j].sr_item_quantity);
         				}

         				if( Number(batchStockArr[j].sr_item_quantity) > feedDataObj[batchStockArr[j].sr_house_id][batchStockArr[j].sr_item].max){
         					feedDataObj[batchStockArr[j].sr_house_id][batchStockArr[j].sr_item].max = Number(batchStockArr[j].sr_item_quantity);
         				}
         			}


         		}
         	}

         	var tdClass = ['colDeath','colCull','colCatch'];
         	var tdCount = 0;

         	var feedTotal = {};

         	for(var obj in feedDataObj){
         		var tdString = '';
         		tdCount = 0;
         		for(var feed in feedDataObj[obj]){

         			tdString = tdString + '<td class="'+tdClass[tdCount]+'">'+feedDataObj[obj][feed].sum+'</td> <td class="'+tdClass[tdCount]+'">'+feedDataObj[obj][feed].min+'</td> <td class="'+tdClass[tdCount]+'">'+feedDataObj[obj][feed].max+'</td>';

         			tdCount = tdCount + 1;

         			if(typeof(feedTotal[feed]) == 'undefined'){
         				feedTotal[feed] = feedDataObj[obj][feed].sum;
         			}else{
         				feedTotal[feed] = feedTotal[feed] + feedDataObj[obj][feed].sum;
         			}
         			
         		}
         		$('#feedTableBody').append('<tr> <th scope="row">'+obj+' 1</th>'+tdString+'</tr>')
         		
         	}

         	$('#overallStarter').text(feedTotal[getCategoryCode('feed','Starter')]);
         	$('#overallGrower').text(feedTotal[getCategoryCode('feed','Grower')]);
         	$('#overallCrumble').text(feedTotal[getCategoryCode('feed','Crumble')]);

         	console.log(feedDataObj);

		}

		function updateCategory(){

			$.ajax({
				url: "assets/php/getCategory.php",
				type: "GET"
			}).done(function(data){
				var response = JSON.parse(data);
				window.category = response;
			});

		}


		function getCategoryCode(level,desc){
		    for(var i=0;i<window.category.length;i++){

		        if(window.category[i].category_level == level && window.category[i].category_desc == desc ){
		            return window.category[i].category_id;
		        }
		    }
		}

		function getCategoryDesc(level,id){
		    for(var i=0;i<window.category.length;i++){

		        if(window.category[i].category_level == level && window.category[i].category_id == id ){
		            return window.category[i].category_desc;
		        }
		    }
		}

		function negativeBracket(data){

            var dataString = "";
            var amount = data.toFixed(2);

            if(!isFinite(amount)){
            	amount = 0;
            }

            if(amount < 0){

            	dataString = '(RM '+(amount * -1)+')';
            }else{
            	dataString = 'RM '+amount;
            }

            return dataString;

		}

		$('.toggleSide').on('click',function(){
			$('.sidePanel').css('left','0');
			$('.sidePanel').css('z-index','100');
			$('.mainContentCover').css('z-index','99');
			$('.mainWrapper').css('overflow-y','hidden');
		})

		$('.mainContentCover').on('click',function(){
			$('.sidePanel').css('left','-300px');
			$('.sidePanel').css('z-index','-99');
			$('.mainContentCover').css('z-index','-100');
			$('.mainWrapper').css('overflow-y','scroll');
		})


	</script>










</body>
</html>