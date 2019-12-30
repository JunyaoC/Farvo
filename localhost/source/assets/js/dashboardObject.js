if(typeof(window.dashboard) != 'function'){

	window.dashboard = class dashboard{

		constructor(_company_id,_access_level){
			this.company_id = _company_id;
			this.farm_list = {};
			this.access_level = Number(_access_level);
			this.view_farm_id = 'overall';
			this.generateDashboard();
		}

		generateDashboard(callback){



			$.ajax({
				url: "assets/php/generateDashboard.php",
				type: "post",
				context: this,
				data: {'company_id':this.company_id}
			}).done(function(data){
				var response = JSON.parse(data);

				var farmResponse = response.farm;				
				for(var i=0;i<farmResponse.length;i++){
					var newFarm = new farm(farmResponse[i]);
					this.farm_list[newFarm.farm_id] = newFarm;
				}


				var houseResponse = response.house;
				for(var i=0;i<houseResponse.length;i++){
					this.farm_list[houseResponse[i].house_farm_id].house_list.push(new house(houseResponse[i]));
				}


				var stockResponse = response.stock;
				for(var i=0;i<stockResponse.length;i++){
					this.farm_list[stockResponse[i].stock_farm_id].stock_list.push(new stock(stockResponse[i]));
				}


				var cycleResponse = response.cycle;
				for(var i=0;i<cycleResponse.length;i++){
					this.farm_list[cycleResponse[i].cycle_farm_id].cycle_list.push(new cycle(cycleResponse[i]));
				}

				var batchResponse = response.batch;

				for(var i=0;i<batchResponse.length;i++){
					for(var obj in this.farm_list){
						for(var j=0;j<this.farm_list[obj].cycle_list.length;j++){
							if(this.farm_list[obj].cycle_list[j].cycle_id == batchResponse[i].batch_cycle_id){
								var newBatch = new batch(batchResponse[i]);
								this.farm_list[obj].cycle_list[j].batch_list.push(newBatch);
							}
						}
					}

				}

				
				console.log(this);

				
				this.updateDOM();

				if(typeof(callback) == 'function'){
					callback();
				}

			});

		}

		updateDOM(){
			this.updateLeftPaneDOM();
			this.updateFarmDOM();

			if(this.view_farm_id == 'overall'){
				$('.dashboardContent').css('display','');
   				$('.houseList').html(this.overall('house'));
   				$('#stockList').html(this.overall('stock'));
   				$('.costTableDiv').html(this.overall('cost'));
   				generateAnalytics();
   				this.overall('cycle');
   				this.overall('chart');
   				$('#batchList').html(this.overall('batch'));
			}
		}

		updateFarmDOM(){
			for(var obj in this.farm_list){
				this.farm_list[obj].updateHouseListDOM();
				this.farm_list[obj].updateStockListDOM();
				for(var j=0;j<this.farm_list[obj].cycle_list.length;j++){
					this.farm_list[obj].viewCycle();
					this.farm_list[obj].cycle_list[j].generateBatchDOM();
				}
			}
		}

		updateLeftPaneDOM(){
			$('.generatedRow').remove();
			console.log('1');
			for(var obj in this.farm_list){
									
				if(this.access_level >= 3){
					$('#farmLeftPanel').append("<div class='row generatedRow'> <div class='col-11 d-flex justify-content-start'> <div class='newButtonColumn'> <div class='dropdown'> <button class='btn btn-secondary d-flex justify-content-center align-items-center' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='border-radius: 3rem;width:100%;height:100%;'><i class='fas fa-plus'></i></button> <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> <a class='dropdown-item' href='#' id='addHouseButton'>House</a> <a class='dropdown-item' href='#' id='addStockButton'>Stock</a> <a class='dropdown-item' href='#' id='addBatchButton'>Batch</a> <a class='dropdown-item' href='#' id='addCostButton'>Cost</a> <a class='dropdown-item' href='#' id='editFarmButton' farm_id='"+this.farm_list[obj].farm_id+"'>Edit Farm</a> <a class='dropdown-item manageFarmer' href='#'>Manage Farmer</a> </div> </div> </div> <div class='farmRow' farm_id='"+this.farm_list[obj].farm_id+"'> <p style='margin: 0;font-family: Cabin, sans-serif;font-weight: 900;'>"+this.farm_list[obj].farm_name+"</p> </div> </div> </div>");
				}else{
					$('#farmLeftPanel').append(" <div class='row generatedRow'> <div class='col-11 d-flex justify-content-start'> <div class='farmRow' farm_id='"+this.farm_list[obj].farm_id+"'> <p style='margin: 0;font-family: Cabin, sans-serif;font-weight: 900;'>"+this.farm_list[obj].farm_name+"</p> </div> </div> </div>");
				}
			}
		}

		overall(param){

			switch(param){

				case 'house':
						var overallHouse = document.createElement("DIV");

						for (var obj in this.farm_list){
							$(overallHouse).append(this.farm_list[obj]['house_list_dom']);
						}

						return overallHouse;
					break;

				case 'stock':
						// var overallStock = document.createElement("DIV");

						// for (var obj in this.farm_list){
						// 	$(overallStock).append(this.farm_list[obj]['stock_list_dom']);
						// }

						var feedArr = [];
						var mainWrapper = document.createElement('DIV');
						$(mainWrapper).attr('class','d-flex flex-column');
						$(mainWrapper).css('height','100%');

						for(var i=0;i<window.category.length;i++){
							if(window.category[i].category_level == 'feed'){
								var newData = {
									feed_id : window.category[i].category_id,
									total : 0
								}
								feedArr.push(newData);

							}
						}

						for(var obj in this.farm_list){
							for(var i=0;i<feedArr.length;i++){

								for(var j=0;j<this.farm_list[obj].stock_list.length;j++){

									for(var k=0;k<this.farm_list[obj].stock_list[j].stock_balance.length;k++){
										if(this.farm_list[obj].stock_list[j].stock_balance[k].sb_item == feedArr[i].feed_id){
											feedArr[i].total = (Number(feedArr[i].total) + Number(this.farm_list[obj].stock_list[j].stock_balance[k].sb_balance));
										}


									}
								}
							}

						}


						var balanceRow = document.createElement('DIV');
						$(balanceRow).attr('class','row');

						for(var j=0;j<feedArr.length;j++){

							var feedName = getCategoryDesc('feed',feedArr[j].feed_id);
							var feedBalance = feedArr[j].total;

							$(balanceRow).append('<div class="col-4 text-center" style="padding:0;"><h6>'+feedName+'</h6><h2>'+feedBalance+'</h2></div>');
						}

						var tableDiv = document.createElement('DIV');
						$(tableDiv).attr('class','table-responsive');
						$(tableDiv).css('overflow-y','scroll');
						$(tableDiv).css('overflow-x','hidden');



						var stockTable = document.createElement('TABLE');
						$(stockTable).attr('class','table table-hover text-center');
						var tableHead = document.createElement('THEAD');
						var tableHeadRow = document.createElement('TR');
						$(tableHeadRow).append('<th scope="col">Stock Name</th>');
						for(var i=0;i<feedArr.length;i++){
							var feed_name = getCategoryDesc('feed',feedArr[i].feed_id);
							var feed_name_initial = feed_name.charAt(0);
							$(tableHeadRow).append('<th scope="col">'+feed_name_initial+'</th>');
						}

						$(tableHead).append(tableHeadRow);

						var tableBody = document.createElement('TBODY');
						for(var obj in this.farm_list){
							for(var i=0;i<this.farm_list[obj].stock_list.length;i++){
								var tableBodyRow = document.createElement('TR');
								$(tableBodyRow).attr('class','detailTrigger');
								$(tableBodyRow).attr('level','stock');
								$(tableBodyRow).append('<th scope="col">'+this.farm_list[obj].stock_list[i].stock_name+'</th>');
					
								for(var j=0;j<feedArr.length;j++){

									var found = false;

									for(var k=0;k<this.farm_list[obj].stock_list[i].stock_balance.length;k++){
										if(feedArr[j].feed_id == this.farm_list[obj].stock_list[i].stock_balance[k].sb_item){
											$(tableBodyRow).append('<td scope="col">'+this.farm_list[obj].stock_list[i].stock_balance[k].sb_balance+'</td>');
											found = true;
										}
									}

									if(!found){
										$(tableBodyRow).append('<td scope="col">0</td>');
									}

								}
								$(tableBody).append(tableBodyRow);
							}	
						}

						$(stockTable).append(tableHead);
						$(stockTable).append(tableBody);

						$(tableDiv).append(stockTable);

						$(mainWrapper).append(balanceRow);
						$(mainWrapper).append(tableDiv);

						return mainWrapper;
					break;

				case 'cycle':

					var active_cycle_id = -1;
					var active_cycle_farm_id = -1;

					var viewportWidth = $(window).width();

					for(var obj in this.farm_list){
						
						for(var i=0;i<this.farm_list[obj].cycle_list.length;i++){
							if(this.farm_list[obj].cycle_list[i].cycle_status == 'active'){
								active_cycle_id = this.farm_list[obj].cycle_list[i].cycle_id;
								active_cycle_farm_id = obj;
							}
						}

						if(active_cycle_id == -1){

							if(viewportWidth < 600){
							}else{
								$('.cycleInitCover').css('zIndex','100');
							}
								$($('.dashboardCard')[0]).addClass('inactive');
								$($('.dashboardCard')[1]).addClass('inactive');
								$($('.dashboardCard')[3]).addClass('inactive');
								$($('.dashboardCard')[4]).addClass('inactive');
								$('#cycleNameDisplay').text('No Active Cycle');
								$('#farmNameDisplay').text(this.farm_name);

							$('#cycleOperation').html('<button class="btn btn-outline-primary cycleAddButton" data-toggle="tooltip" data-placement="top" title="Start New Cycle"><i class="fas fa-play"></i></button>');
						} else{
							$('#cycleOperation').html('<button class="btn btn-outline-primary stopCycle" data-toggle="tooltip" data-placement="top" title="Stop Cycle"><i class="fas fa-stop"></i></button>');
							$('.cycleInitCover').css('zIndex','-100');
							$('.dashboardCard').removeClass('inactive');
							$('#cycleNameDisplay').text('Cycle Overview');
							$('#farmNameDisplay').text(this.farm_name);
						}

					}

					break;

				case 'batch':

					var overallBatch = document.createElement("DIV");
					$(overallBatch).attr('class','table-responsive');

					var batchTableBody = document.createElement("TBODY");

					for (var obj in this.farm_list){

						var currentActive = Number(this.farm_list[obj].active_cycle_id);
						for(var j=0;j< this.farm_list[obj]['cycle_list'].length;j++){
							if(this.farm_list[obj]['cycle_list'][j].cycle_id == currentActive){

								var currentBatchCycle = this.farm_list[obj]['cycle_list'][j]['batch_list'];	

								var fcr = 'N/A';
								var pi = 'N/A';						

								for(var k=0;k<currentBatchCycle.length;k++){

									for(var batchData in window.batchAnalytics){

										if(batchData == currentBatchCycle[k].batch_uid){
											if(!isNaN(window.batchAnalytics[batchData]['fcr'])){
												fcr = window.batchAnalytics[batchData]['fcr'];
												fcr = fcr.toFixed(2);
											}
											
											if(!isNaN(window.batchAnalytics[batchData]['pi'])){
												pi = window.batchAnalytics[batchData]['pi'];
												pi = pi.toFixed(2);
											}
											break;
										}

									}
									

									$(batchTableBody).append('<tr class="detailTrigger" level="batch" detail_id="'+currentBatchCycle[k].batch_uid+'" batch_id="'+currentBatchCycle[k].batch_uid+'"> <th>'+currentBatchCycle[k].batch_name+'</th> <td class="fcrDisplay">'+fcr+'</td> <td class="fcrDisplay">'+pi+'</td> </tr>')

								}

								// $(overallBatch).append(this.farm_list[obj]['cycle_list'][j].batch_dom);
								
							}
						}
					}

					$(overallBatch).append('<table class="table table-hover" style="font-size:1rem;text-align:left;"> <thead> <tr> <th scope="col">Name</th> <th scope="col">FCR</th> <th scope="col">PI</th> </tr> </thead> <tbody>'+$(batchTableBody).html()+'</tbody> </table>');

					return overallBatch;


					break;

				case 'cost':

					var overallCost = document.createElement("DIV");
					var overallCostTableBody = document.createElement("TBODY");

					var totalCostDisplay = 0;
					var totalGPLCost = 0;

					for (var obj in this.farm_list){

						var currentActive = Number(this.farm_list[obj].active_cycle_id);
						for(var j=0;j< this.farm_list[obj]['cycle_list'].length;j++){
							if(this.farm_list[obj]['cycle_list'][j].cycle_id == currentActive){

								for(var i=0;i<this.farm_list[obj]['cycle_list'][j].cycle_cost.length;i++){

									var costNote = this.farm_list[obj]['cycle_list'][j].cycle_cost[i].cost_note;
									costNote = costNote.split('\n').join('<br>');

									if(getCategoryDesc('cost',this.farm_list[obj]['cycle_list'][j].cycle_cost[i].cost_category) == 'day 0 chick' || getCategoryDesc('cost',this.farm_list[obj]['cycle_list'][j].cycle_cost[i].cost_category) == 'medication & supplements'){
										totalGPLCost = totalGPLCost + Number(this.farm_list[obj]['cycle_list'][j].cycle_cost[i].cost_amount);
									}

									$(overallCostTableBody).append('<tr> <td>'+this.farm_list[obj]['cycle_list'][j].cycle_cost[i].cost_date+'</td> <td>'+getCategoryDesc('cost',this.farm_list[obj]['cycle_list'][j].cycle_cost[i].cost_category)+'</td> <td>'+costNote+'</td> <td>'+this.farm_list[obj]['cycle_list'][j].cycle_cost[i].cost_amount+'</td> </tr>');

									totalCostDisplay = totalCostDisplay + Number(this.farm_list[obj]['cycle_list'][j].cycle_cost[i].cost_amount);

								}
								break;
							}
						}
					}

					$('#totalGrossCostDisplay').text('RM '+totalGPLCost);
					$('#totalCostDisplay').text('RM '+totalCostDisplay);

					$(overallCost).append('<table class="table"> <thead> <tr> <th scope="col">Date</th> <th scope="col">Category</th> <th scope="col">Remarks</th> <th scope="col">RM</th> </tr> </thead> '+$(overallCostTableBody).html()+' </table>');

					return overallCost;


					break;

				case 'chart':

					var dateArr = [];
					var batchNameArr = [];
					var birdDeathArr = [];
					var birdCatchArr = [];
					var birdCullArr = [];
					var birdBalanceArr = [];

					var totalObject = {};

					for(var batch_id in window.batchAnalytics){
						var chartArr = window.batchAnalytics[batch_id]['chart'];						

						for(var obj in chartArr){

							if(typeof(totalObject[obj]) == 'undefined'){
								totalObject[obj] = {
									bird_death: Number(chartArr[obj].bird_death),
									bird_cull:Number(chartArr[obj].bird_cull),
									bird_catch:Number(chartArr[obj].bird_catch),
									bird_balance:Number(chartArr[obj].bird_balance)
								}
							}else{
								totalObject[obj].bird_death = totalObject[obj].bird_death + Number(chartArr[obj].bird_death);
								totalObject[obj].bird_cull = totalObject[obj].bird_cull + Number(chartArr[obj].bird_cull);
								totalObject[obj].bird_catch = totalObject[obj].bird_catch + Number(chartArr[obj].bird_catch);
								totalObject[obj].bird_balance = totalObject[obj].bird_balance + Number(chartArr[obj].bird_balance);
							}
						}
					}

					for(var obj in totalObject){
						dateArr.push(obj);
						birdDeathArr.push(totalObject[obj].bird_death);
						birdCullArr.push(totalObject[obj].bird_cull);
						birdCatchArr.push(totalObject[obj].bird_catch);
						birdBalanceArr.push(totalObject[obj].bird_balance);			
					}

					console.log('tt',totalObject);

					if(typeof(window.overviewChart) === 'function'){
						window.overviewChart.destroy();
					}

					var overviewChartDOM = document.getElementById('overviewChart').getContext('2d');
					overviewChartDOM.canvas.width = $('#overviewChartDiv').width();
                	overviewChartDOM.canvas.width = $('#overviewChartDiv').height();

					window.overviewChart = new Chart(window.overviewChart, {
					    // The type of chart we want to create
					    type: 'line',

					    // The data for our dataset
					    data: {
					        labels: dateArr,
					        datasets: [
				        	{
					            label: 'Death',
					            data: birdDeathArr,
					            fill: false
					        },
					        {
					            label: 'Cull',
					            data: birdCullArr,
					            fill: false
					        },
					        {
					            label: 'Catch',
					            data: birdCatchArr,
					            fill: false
					        },
					        {
					            label: 'Balance',
					            data: birdBalanceArr,
					            fill: false,
					            hidden: true
					        }]
					    },

					    // Configuration options go here
					    options: {
					    	responsive: true,
					    	maintainAspectRatio: false,
					    	plugins: {

	                          colorschemes: {

	                            scheme: 'office.Feathered6'

	                          }

	                        }

					    }
					});

					break;

			}


		}



	}
}

if(typeof(window.farm) != 'function'){

	window.farm = class farm{

		constructor(obj){
			this.farm_company_id = obj.farm_company_id;
			this.farm_id = obj.farm_id;
			this.farm_address = obj.farm_address;
			this.farm_joinDt = obj.farm_joinDt;
			this.farm_cat = obj.farm_cat;
			this.farm_name = obj.farm_name;
			this.farm_access = obj.farm_access;

			this.house_list = [];
			this.stock_list = [];
			this.house_list_dom = document.createElement("DIV");
			this.stock_list_dom = document.createElement("DIV");

			this.cycle_list = [];
			this.active_cycle_id = -1;

		}

		updateHouseListDOM(){

			this.house_list_dom = document.createElement("DIV");

			for(var i=0;i<this.house_list.length;i++){
				var newDiv = document.createElement("DIV");
				$(newDiv).attr('class','row detailTrigger');
				$(newDiv).attr('level','house');
				$(newDiv).attr('detail_id',this.farm_id);
				$(newDiv).append("<div class='col'><h6 class='d-xl-flex align-items-xl-center' style='height: 100%;width: 100%;'><i class='fa fa-circle' style='padding: 0 0.5rem 0 0;font-size: 12px;color: rgb(5,193,35);'></i>" + this.house_list[i].house_name + "</h6></div><div class='col d-xl-flex align-items-xl-center'><div style='width: 100%;'><div class='progress' style='width: 100%;'><div class='progress-bar' aria-valuenow='" + (this.house_list[i].house_capacity - this.house_list[i].house_used_capacity) + "' aria-valuemin='0' aria-valuemax='" + this.house_list[i].house_capacity + "' style='width:" + ((this.house_list[i].house_used_capacity) / this.house_list[i].house_capacity)  * 100 +"%'>" + this.house_list[i].house_used_capacity +"</div></div></div></div>");

				$(this.house_list_dom).append(newDiv);

			}

		}

		updateStockListDOM(){

			this.stock_list_dom = document.createElement("DIV");

			var feedArr = [];

			for(var i=0;i<window.category.length;i++){
				if(window.category[i].category_level == 'feed'){
					var newData = {
						feed_id : window.category[i].category_id,
						total : 0
					}
					feedArr.push(newData);

				}
			}

			for(var i=0;i<feedArr.length;i++){

				for(var j=0;j<this.stock_list.length;j++){

					for(var k=0;k<this.stock_list[j].stock_balance.length;k++){
						if(this.stock_list[j].stock_balance[k].sb_item == feedArr[i].feed_id){
							feedArr[i].total = (Number(feedArr[i].total) + Number(this.stock_list[j].stock_balance[k].sb_balance));
						}


					}
				}
			}

			var balanceRow = document.createElement('DIV');
			$(balanceRow).attr('class','row');

			for(var j=0;j<feedArr.length;j++){

				var feedName = getCategoryDesc('feed',feedArr[j].feed_id);
				var feedBalance = feedArr[j].total;

				$(balanceRow).append('<div class="col-4 text-center" style="padding:0;"><h6>'+feedName+'</h6><h2>'+feedBalance+'</h2></div>');
			}

			var tableDiv = document.createElement('DIV');
			$(tableDiv).attr('class','table-responsive');
			$(tableDiv).css('overflow-y','scroll');
			$(tableDiv).css('overflow-x','hidden');


			var stockTable = document.createElement('TABLE');
			$(stockTable).attr('class','table table-hover text-center');
			var tableHead = document.createElement('THEAD');
			var tableHeadRow = document.createElement('TR');
			$(tableHeadRow).append('<th scope="col">Stock Name</th>');
			for(var i=0;i<feedArr.length;i++){
				var feed_name = getCategoryDesc('feed',feedArr[i].feed_id);
				var feed_name_initial = feed_name.charAt(0);
				$(tableHeadRow).append('<th scope="col">'+feed_name_initial+'</th>');
			}

			$(tableHead).append(tableHeadRow);

			var tableBody = document.createElement('TBODY');

				for(var i=0;i<this.stock_list.length;i++){
					var tableBodyRow = document.createElement('TR');
					$(tableBodyRow).attr('class','detailTrigger');
					$(tableBodyRow).attr('level','stock');
					$(tableBodyRow).append('<th scope="col">'+this.stock_list[i].stock_name+'</th>');
		
					for(var j=0;j<feedArr.length;j++){

						var found = false;

						for(var k=0;k<this.stock_list[i].stock_balance.length;k++){
							if(feedArr[j].feed_id == this.stock_list[i].stock_balance[k].sb_item){
								$(tableBodyRow).append('<td scope="col">'+this.stock_list[i].stock_balance[k].sb_balance+'</td>');
								found = true;
							}
						}

						if(!found){
							$(tableBodyRow).append('<td scope="col">0</td>');
						}

					}
					$(tableBody).append(tableBodyRow);
	
			}

			$(stockTable).append(tableHead);
			$(stockTable).append(tableBody);

			$(tableDiv).append(stockTable);

			$(balanceRow).append(tableDiv);

			this.stock_list_dom = balanceRow;			
		}

		viewCycle(){

			var active_cycle_id = -1;
			var active_cycle_farm_id = -1;
			var active_cycle_name;

			var viewportWidth = $(window).width();			

			for(var i=0;i<this.cycle_list.length;i++){
				if(this.cycle_list[i].cycle_status == 'active'){
					active_cycle_id = this.cycle_list[i].cycle_id;
					active_cycle_farm_id = this.farm_id;
					active_cycle_name = this.cycle_list[i].cycle_name;
				}
			}

			this.active_cycle_id = active_cycle_id;

			if(active_cycle_id == -1){
				if(viewportWidth < 600){
				}else{
					$('.cycleInitCover').css('zIndex','100');
				}
					$('#cycleOperation').html('<button class="btn btn-outline-primary cycleAddButton" data-toggle="tooltip" data-placement="top" title="Start New Cycle"><i class="fas fa-play"></i></button>');
					$('#cycleNameDisplay').text('No Active Cycle');
					$($('.dashboardCard')[0]).addClass('inactive');
					$($('.dashboardCard')[1]).addClass('inactive');
					$($('.dashboardCard')[3]).addClass('inactive');
					$($('.dashboardCard')[4]).addClass('inactive');
			} else{
				$('#cycleOperation').html('<button class="btn btn-outline-primary stopCycle" data-toggle="tooltip" data-placement="top" title="Stop Cycle"><i class="fas fa-stop"></i></button>');
				$('.cycleInitCover').css('zIndex','-100');
				$('.dashboardCard').removeClass('inactive');
				$('#cycleNameDisplay').text(active_cycle_name);
			}






		}

	}
}

if(typeof(window.house) != 'function'){

	window.house = class house{

		constructor(obj){
			this.house_id = obj.house_id;
			this.house_capacity = obj.house_capacity;
			this.house_cat = obj.house_cat;
			this.house_farm_id = obj.house_farm_id;
			this.house_status = obj.house_status;
			this.house_used_capacity = obj.house_used_capacity;
			this.house_name = obj.house_name;
		}

	}
}

if(typeof(window.stock) != 'function'){

	window.stock = class stock{

		constructor(obj){
			this.stock_id = obj.stock_id;
			this.stock_farm_id = obj.stock_farm_id;
			this.stock_name = obj.stock_name;
			this.stock_balance = obj.stock_balance;
		}

	}
}

if(typeof(window.cycle) != 'function'){

	window.cycle = class cycle{

		constructor(obj){
			this.cycle_id = obj.cycle_id;
			this.cycle_init_date = obj.cycle_init_date;
			this.cycle_status = obj.cycle_status;
			this.cycle_name = obj.cycle_name;
			this.cycle_cost = obj.cycle_cost;

			this.batch_list = [];
			this.batch_dom = document.createElement('DIV');
		}

		generateBatchDOM(){

			$(this.batch_dom).empty();

			var overallBatch = document.createElement("DIV");
			$(overallBatch).attr('class','table-responsive');

			var batchTableBody = document.createElement("TBODY");

			for(var i=0;i<this.batch_list.length;i++){

				var fcr = 'N/A';
				var pi = 'N/A';	

				for(var batchData in window.batchAnalytics){
					console.log(batchData,this.batch_list[i].batch_uid)
					if(batchData == this.batch_list[i].batch_uid){
						if(!isNaN(window.batchAnalytics[batchData]['fcr'])){
							fcr = window.batchAnalytics[batchData]['fcr'];
							fcr = fcr.toFixed(2);
						}

						if(!isNaN(window.batchAnalytics[batchData]['pi'])){
							pi = window.batchAnalytics[batchData]['pi'];
							pi = pi.toFixed(2);
						}
						
						break;
					}
				}

				$(batchTableBody).append('<tr class="detailTrigger" level="batch" detail_id="'+this.batch_list[i].batch_uid+'" batch_id="'+this.batch_list[i].batch_uid+'"> <th>'+this.batch_list[i].batch_name+'</th> <td class="fcrDisplay">'+fcr+'</td> <td class="fcrDisplay">'+pi+'</td> </tr>')
			}

			$(overallBatch).append('<table class="table table-hover" style="font-size:1rem;text-align:left;"> <thead> <tr> <th scope="col">Name</th> <th scope="col">FCR</th> <th scope="col">PI</th> </tr> </thead> <tbody>'+$(batchTableBody).html()+'</tbody> </table>');

			this.batch_dom = overallBatch;

		}


	}

}

if(typeof(window.batch) != 'function'){

	window.batch = class batch{

		constructor(obj){
			this.batch_uid = obj.batch_uid;
			this.batch_name = obj.batch_name;
			this.batch_type = obj.batch_type;
			this.batch_date = obj.batch_date;
			this.batch_status = obj.batch_status;
			this.batch_record = obj.batch_record;
			this.batch_stock_record = obj.batch_stock_record;
			this.batch_event = obj.batch_event;
			this.batch_house_balance = obj.batch_house_balance;
		}


	}

}

if(typeof(window.category) != 'function'){

	updateCategory();

}

function updateCategory(){

	$.ajax({
		url: "assets/php/getCategory.php",
		type: "GET"
	}).done(function(data){
		var response = JSON.parse(data);
		window.category = response;
		console.log(window.category);
		///clear options

        $('select[name="event_type"]').empty();

        for(var i=0;i<window.category.length;i++){
            if(window.category[i].category_level == 'event'){
                $('select[name="event_type"]').append('<option value="'+window.category[i].category_id+'">'+window.category[i].category_desc+'</option>');
            }
        }

        $('select[name="cost_category"]').empty();

        for(var i=0;i<window.category.length;i++){
            if(window.category[i].category_level == 'cost'
            	&& window.category[i].category_desc != 'day o chick'
            	&& window.category[i].category_desc != 'feed'

            	){
                $('select[name="cost_category"]').append('<option value="'+window.category[i].category_id+'">'+window.category[i].category_desc+'</option>');
            }
        }

        $('select[name="edit_farm_cat"]').empty();

        for(var i=0;i<window.category.length;i++){
            if(window.category[i].category_level == 'farm'){
                $('select[name="edit_farm_cat"]').append('<option value="'+window.category[i].category_id+'">'+window.category[i].category_desc+'</option>');
            }
        }

        $('select[name="house_cat"]').empty();

        for(var i=0;i<window.category.length;i++){
            if(window.category[i].category_level == 'house'){
                $('select[name="house_cat"]').append('<option value="'+window.category[i].category_id+'">'+window.category[i].category_desc+'</option>');
            }
        }

        $('select[name="house_status"]').empty();

        for(var i=0;i<window.category.length;i++){
            if(window.category[i].category_level == 'house_status'){
                $('select[name="house_status"]').append('<option value="'+window.category[i].category_id+'">'+window.category[i].category_desc+'</option>');
            }
        }

        $('select[name="farm_cat"]').empty();

        for(var i=0;i<window.category.length;i++){
            if(window.category[i].category_level == 'farm'){
                $('select[name="farm_cat"]').append('<option value="'+window.category[i].category_id+'">'+window.category[i].category_desc+'</option>');
            }
        }









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

function writeToFirebase(){

	// firebase.database().ref(window._dashboard.company_id).update({
	// 	last_change : firebase.database.ServerValue.TIMESTAMP
	// });

}

// firebase.database().ref('/').on('value',function(data){
// 	window._dashboard.generateDashboard();
// })