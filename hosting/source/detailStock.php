<?php

?>

<style type="text/css">

	.stockWrapper{
		padding: 1rem;
		width: 100%;
		height: 100%;
		border-radius: 0.5rem 0 0 0;
		display: flex;
		justify-content: flex-start;
		flex-direction: row;
	}
		
	.leftPanel{
		margin: -1rem 0 -1rem -1rem;
		border-radius: 0 0 0 0.5rem;
		height: 100% + 2rem;
		background: white;
		width: 400px;

	}

	.leftPanelChartDiv{
		height: 30vh;
		width: 100%;
	}

	@media only screen and (max-width: 600px) {
		.stockWrapper{
			padding: 1rem;
			width: 100%;
			height: 100%;
			border-radius: 0.5rem 0 0 0;
			display: flex;
			justify-content: center;
			flex-direction: row;
		}

		.leftPanel{
			margin: 0;
			height: 100%;
			background: none;
			width: 100%;
		}

		.leftPanelChartDiv{
			height: 30vh;
			width: 100%;
		}

	}


</style>

<div style="padding:1rem; height: 100%;">
	<div class="row" style="height: 100%;">
		<div class="col-md-4" style="height: 100%;">
			<div class="leftPanelChartDiv">
				<canvas id="totalStockCanvas"></canvas>
			</div>
			<div style="padding: 1rem;">
				<h5 class="text-center">Total Balance: </h5>
				<div class="row" id="totalFeedRow">
					<!-- <div class="col text-center">
						<h6>Starter</h6>
						<h2>30</h2>
						<p style="font-size: 0.8rem;">Notify when less than 20 bags left.</p>
						<a href="#">Change</a>
					</div>
					<div class="col text-center">
						<h6>Crumble</h6>
						<h2>40</h2>
						<p style="font-size: 0.8rem;">Notify when less than 20 bags left.</p>
						<a href="#">Change</a>
					</div>
					<div class="col text-center">
						<h6>Grower</h6>
						<h2>50</h2>
						<p style="font-size: 0.8rem;">Notify when less than 20 bags left.</p>
						<a href="#">Change</a>
					</div> -->
				</div>
			</div>
		</div>
		<div class="col-md-8" style="height: 100%;" id="stockCardCol">
			<div id="stockCardDesk" class="row"></div>
			
		</div>


	</div>
</div>


<script type="text/javascript">

	$('#stockCardDesk').empty();

	if(window._dashboard.view_farm_id == 'overall'){

		var totalFeedObj = {};

		for(var obj in window._dashboard.farm_list){

			for(var i=0;i<window._dashboard.farm_list[obj].stock_list.length;i++){

				var feedNameArr = [];
				var feedBalanceArr = [];

				var balanceRow = document.createElement('DIV');
				$(balanceRow).attr('class','row');

				var recordExist = false;

				for(var j=0;j<window._dashboard.farm_list[obj].stock_list[i].stock_balance.length;j++){

					var feedName = getCategoryDesc('feed',window._dashboard.farm_list[obj].stock_list[i].stock_balance[j].sb_item);
					var feedBalance = window._dashboard.farm_list[obj].stock_list[i].stock_balance[j].sb_balance;

					feedNameArr.push(feedName);
					feedBalanceArr.push(feedBalance);

					recordExist = true;

					if(typeof(totalFeedObj[feedName]) === 'undefined'){
						totalFeedObj[feedName] = feedBalance;
					} else{
						totalFeedObj[feedName] = Number(totalFeedObj[feedName]) + Number(feedBalance);
					}

					$(balanceRow).append('<div class="col-4 text-center" style="padding:0;"><h6>'+feedName+'</h6><h2>'+feedBalance+'</h2></div>');
				}

				if(!recordExist){
					$(balanceRow).append('<div class="col text-center" style="padding:0;"><h4>No Record</h4></div>');
				}

				// $('#stockCardDesk').append('<div class="col-md-4 col-sm-12"><div class="card" style="width: 16rem;margin:0;"> <div class="card-body"><h5 class="card-title text-center">'+window._dashboard.farm_list[obj].stock_list[i].stock_name+'</h5><div style="height:22vh;"></div><div class="row">' +$(balanceRow).html()+ '</div><a href="#" class="btn btn-primary stockAddFeedButton" stock_id="'+window._dashboard.farm_list[obj].stock_list[i].stock_id+'">Add Stock</a></div></div></div></div>');

				$('#stockCardDesk').append('<div class="stockcolumn"><div class="stockcard"><h5 class="card-title text-center">'+window._dashboard.farm_list[obj].stock_list[i].stock_name+'</h5><div style="height:22vh;" class="stockCanvasDiv"><canvas id="stockCanvas'+window._dashboard.farm_list[obj].stock_list[i].stock_id+'"></canvas></div><div class="row">' +$(balanceRow).html()+ '</div><a href="#" class="btn btn-primary stockAddFeedButton" stock_id="'+window._dashboard.farm_list[obj].stock_list[i].stock_id+'" cycle_id="'+window._dashboard.farm_list[obj].active_cycle_id+'">Add Stock</a></div></div></div></div>');

				var data = {
		        labels: feedNameArr,
		        datasets: [
		        		{
		            		data: feedBalanceArr
		        		}
		       	 ]
		    	};
				
		     	var ctx = $("#stockCanvas"+window._dashboard.farm_list[obj].stock_list[i].stock_id).get(0).getContext("2d");
		        var myChart = new Chart(ctx, {
		          type: 'doughnut',
		          data: data
		         });

		        feedNameArr = [];
				feedBalanceArr = [];


			}


		}

		$('#totalFeedRow').empty();

		var totalFeedCount = Object.keys(totalFeedObj);
		totalFeedCount = totalFeedCount.length;

		console.log(totalFeedObj);

		var totalFeedName = [];
		var totalFeedBalance = [];

		for(var obj in totalFeedObj){
			totalFeedName.push(obj);
			totalFeedBalance.push(totalFeedObj[obj]);
		}

		var data = {
        labels: totalFeedName,
        datasets: [
        		{
            		data: totalFeedBalance
        		}
       	 ]
    	};
		
     	var ctx = $("#totalStockCanvas").get(0).getContext("2d");
        var myChart = new Chart(ctx, {
          type: 'doughnut',
          data: data
         });


		for(var i=0;i<window.category.length;i++){

			if(window.category[i].category_level == "feed"){

				var dataExist = false;

				if(totalFeedObj[window.category[i].category_desc] != undefined){	///feed is in use

					var priceExist = false;
					dataExist = true;

					for(var j=0;j<window.category.length;j++){

						if(window.category[j].category_level == 'feed_price' && window.category[j].category_code == window.category[i].category_id){

							$('#totalFeedRow').append('<div class="col text-center"> <h6>'+window.category[i].category_desc+'</h6> <h4>'+totalFeedObj[window.category[i].category_desc]+'</h4>  <p>Price Per Bag: RM '+window.category[j].category_desc+'</p> <a href="#" class="feedPriceEdit" feed_price_id="'+window.category[j].category_id+'" feed_price="'+window.category[j].category_desc+'" feed_id="'+window.category[i].category_id+'">Edit</a> </div>');

							priceExist = true;
							break;
						}

					}

					if(!priceExist){
						$('#totalFeedRow').append('<div class="col text-center"> <h6>'+window.category[i].category_desc+'</h6> <h4>'+totalFeedObj[window.category[i].category_id]+'</h4>  <p>Price Per Bag: - </p> <a href="#" id="feedPriceSet" feed_id="'+window.category[i].category_id+'">Set</a> </div>');
					}

				}

				if(!dataExist){
					for(var j=0;j<window.category.length;j++){

						if(window.category[j].category_level == 'feed_price' && window.category[j].category_code == window.category[i].category_id){

							$('#totalFeedRow').append('<div class="col text-center"> <h6>'+window.category[i].category_desc+'</h6> <h4>0</h4>  <p>Price Per Bag: RM '+window.category[j].category_desc+'</p> <a href="#" class="feedPriceEdit" feed_price_id="'+window.category[j].category_id+'" feed_price="'+window.category[j].category_desc+'" feed_id="'+window.category[i].category_id+'">Edit</a> </div>');

							priceExist = true;
							break;
						}

					}

					if(!priceExist){
						$('#totalFeedRow').append('<div class="col text-center"> <h6>'+window.category[i].category_desc+'</h6> <h4>0</h4>  <p>Price Per Bag: - </p> <a href="#" id="feedPriceSet" feed_id="'+window.category[i].category_id+'">Set</a> </div>');
					}
					
				}


			}


		}


	}else{

		var totalFeedObj = {};

		for(var i=0;i<window._dashboard.farm_list[window._dashboard.view_farm_id].stock_list.length;i++){

			var feedNameArr = [];
			var feedBalanceArr = [];
			var balanceRow = document.createElement('DIV');

			$(balanceRow).attr('class','row');

			var recordExist = false;

			for(var j=0;j<window._dashboard.farm_list[window._dashboard.view_farm_id].stock_list[i].stock_balance.length;j++){

				var feedName = getCategoryDesc('feed',window._dashboard.farm_list[window._dashboard.view_farm_id].stock_list[i].stock_balance[j].sb_item);
				var feedBalance = window._dashboard.farm_list[window._dashboard.view_farm_id].stock_list[i].stock_balance[j].sb_balance;

				feedNameArr.push(feedName);
				feedBalanceArr.push(feedBalance);

				recordExist = true;

				if(typeof(totalFeedObj[feedName]) === 'undefined'){
					totalFeedObj[feedName] = feedBalance;
				} else{
					totalFeedObj[feedName] = Number(totalFeedObj[feedName]) + Number(feedBalance);
				}

				$(balanceRow).append('<div class="col-4 text-center" style="padding:0;"><h6>'+feedName+'</h6><h2>'+feedBalance+'</h2></div>');

			}

			if(!recordExist){
				$(balanceRow).append('<div class="col text-center" style="padding:0;"><h4>No Record</h4></div>');
			}



			// $('#stockCardDesk').append('<div class="row justify-content-center" style="width: 100%;margin:0;"><div class="col-md-4 col-sm-12"><div class="card" style="width: 16rem;margin:0;"> <div class="card-body"><h5 class="card-title text-center">'+window._dashboard.farm_list[window._dashboard.view_farm_id].stock_list[i].stock_name+'</h5><div style="height:22vh;"></div><div class="row">' +$(balanceRow).html()+ '</div><a href="#" class="btn btn-primary stockAddFeedButton" stock_id="'+window._dashboard.farm_list[window._dashboard.view_farm_id].stock_list[i].stock_id+'">Add Stock</a></div></div></div></div>');
			$('#stockCardDesk').append('<div class="stockcolumn";><div class="stockcard"><h5 class="card-title text-center">'+window._dashboard.farm_list[window._dashboard.view_farm_id].stock_list[i].stock_name+'</h5><div style="height:22vh;" class="stockCanvasDiv"><canvas id="stockCanvas'+window._dashboard.farm_list[window._dashboard.view_farm_id].stock_list[i].stock_id+'"></canvas></div><div class="row">' +$(balanceRow).html()+ '</div><a href="#" class="btn btn-primary stockAddFeedButton" stock_id="'+window._dashboard.farm_list[window._dashboard.view_farm_id].stock_list[i].stock_id+'">Add Stock</a></div></div></div></div>');

			var data = {
		        labels: feedNameArr,
		        datasets: [
		        		{
		            		data: feedBalanceArr
		        		}
		       	 ]
		    	};
				
	     	var ctx = $("#stockCanvas"+window._dashboard.farm_list[window._dashboard.view_farm_id].stock_list[i].stock_id).get(0).getContext("2d");
	        var myChart = new Chart(ctx, {
	          type: 'doughnut',
	          data: data
	         });
		}

		$('#totalFeedRow').empty();

		var totalFeedCount = 0;

		var totalFeedName = [];
		var totalFeedBalance = [];

		for(var obj in totalFeedObj){
			totalFeedName.push(obj);
			totalFeedBalance.push(totalFeedObj[obj]);
		}

		var data = {
        labels: totalFeedName,
        datasets: [
        		{
            		data: totalFeedBalance
        		}
       	 ]
    	};
		
     	var ctx = $("#totalStockCanvas").get(0).getContext("2d");
        var myChart = new Chart(ctx, {
          type: 'doughnut',
          data: data
         });


		for(var i=0;i<window.category.length;i++){
			if(window.category[i].category_level == 'feed'){
				totalFeedCount = totalFeedCount + 1;
			}
		}

		var columnSize = 12/totalFeedCount;

		for(var i=0;i<window.category.length;i++){

			if(window.category[i].category_level == "feed"){

				var dataExist = false;

				if(totalFeedObj[window.category[i].category_desc] != undefined){	///feed is in use

					var priceExist = false;
					dataExist = true;

					for(var j=0;j<window.category.length;j++){

						if(window.category[j].category_level == 'feed_price' && window.category[j].category_code == window.category[i].category_id){

							$('#totalFeedRow').append('<div class="col-'+columnSize+' text-center"> <h6>'+window.category[i].category_desc+'</h6> <h4>'+totalFeedObj[window.category[i].category_desc]+'</h4>  <p>Price Per Bag: RM '+window.category[j].category_desc+'</p> <a href="#" class="feedPriceEdit" feed_price_id="'+window.category[j].category_id+'" feed_price="'+window.category[j].category_desc+'" feed_id="'+window.category[i].category_id+'">Edit</a> </div>');

							priceExist = true;
							break;
						}

					}

					if(!priceExist){
						$('#totalFeedRow').append('<div class="col-'+columnSize+' text-center"> <h6>'+window.category[i].category_desc+'</h6> <h4>'+totalFeedObj[window.category[i].category_id]+'</h4>  <p>Price Per Bag: - </p> <a href="#" id="feedPriceSet" feed_id="'+window.category[i].category_id+'">Set</a> </div>');
					}

				}

				if(!dataExist){
					for(var j=0;j<window.category.length;j++){

						if(window.category[j].category_level == 'feed_price' && window.category[j].category_code == window.category[i].category_id){

							$('#totalFeedRow').append('<div class="col-'+columnSize+' text-center"> <h6>'+window.category[i].category_desc+'</h6> <h4>0</h4>  <p>Price Per Bag: RM '+window.category[j].category_desc+'</p> <a href="#" id="feedPriceEdit" class="feedPriceEdit" feed_price_id="'+window.category[j].category_id+'" feed_price="'+window.category[j].category_desc+'" feed_id="'+window.category[i].category_id+'">Edit</a> </div>');

							priceExist = true;
							break;
						}

					}

					if(!priceExist){
						$('#totalFeedRow').append('<div class="col-'+columnSize+' text-center"> <h6>'+window.category[i].category_desc+'</h6> <h4>0</h4>  <p>Price Per Bag: - </p> <a href="#" id="feedPriceSet" feed_id="'+window.category[i].category_id+'">Set</a> </div>');
					}
					
				}


			}


		}

	}

	$(document).on('click','#feedPriceSet',function(){

		var feed_id = $(this).attr('feed_id');

		$('#feedPriceModal').modal('show');
        $('#feedPriceForm').find('input').removeAttr('disabled');
        $('#feedPriceForm').find('textarea').removeAttr('disabled');
        $('#feedPriceForm').find('select').removeAttr('disabled');
        $('#feedPriceConfirm').removeAttr('disabled');
        $('#feedPriceConfirm').html('Set');

        $('#feedPriceForm').empty();

		$('#feedPriceForm').append('<div class="row"> <label for="feed_id">Price Per Bag for '+getCategoryDesc('feed',feed_id)+'</label> <div class="col-3"> RM </div> <div class="col-9"> <div class="form-group">  <input class="form-control" name="feed_price_amount" type="number" min="0"></input> </div> <input type="hidden" name="feed_id" value="'+feed_id+'"><input type="hidden" name="operation" value="set"> </div> </div>');

	});

	$(document).on('click','.feedPriceEdit',function(){

		 var feed_price_id = $(this).attr('feed_price_id');
        var feed_id = $(this).attr('feed_id');
        var feed_price = $(this).attr('feed_price');

        $('#feedPriceModal').modal('show');
        $('#feedPriceForm').find('input').removeAttr('disabled');
        $('#feedPriceForm').find('textarea').removeAttr('disabled');
        $('#feedPriceForm').find('select').removeAttr('disabled');
        $('#feedPriceConfirm').removeAttr('disabled');
        $('#feedPriceConfirm').html('Edit');

        $('#feedPriceForm').empty();

        $('#feedPriceForm').append('<label for="feed_id">Price Per Bag for '+getCategoryDesc('feed',feed_id)+'</label> <div class="row"> <div class="col-3"> RM </div> <div class="col-9 form-group"> <input class="form-control" name="feed_price_amount" value="'+feed_price+'" type="number" min="0"></input> <input type="hidden" name="feed_price_id" value="'+feed_price_id+'"><input type="hidden" name="operation" value="edit"></div>');

			

	});

	$(document).on('click','#feedPriceConfirm',function(){
		validateForm('feedPriceForm');
	})

	$(document).ready(function(){
	    if(window._dashboard.access_level == 2){
	        $('.feedPriceEdit').remove();
	        $('.stockAddFeedButton').remove();
	    };
	})





</script>