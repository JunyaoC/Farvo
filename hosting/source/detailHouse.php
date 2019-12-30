<?php
	$farm_id = $_POST['detail'];
?>


<style type="text/css">
	
	.houseMainWrapper{
		display: flex;
		justify-content: flex-start;
		width: 100%;
		height: 100%;
		overflow-x: scroll;
		overflow-y: hidden;
		white-space: nowrap;
		-webkit-overflow-scrolling: touch;
		padding: 1rem;
	}

	.houseCard{
		width: 400px;
		display: inline-block;
		padding: 1rem;
		margin: 0 1rem;
		background-color: white;
		border-radius: 0.5rem;
	}

	.houseChartDiv{
		height: 30%;
		width: 100%;
	}

	@media only screen and (max-width: 600px) {

		.houseMainWrapper{
			display: flex;
			justify-content: flex-start;
			width: 100%;
			height: 100%;
			overflow-x: scroll;
			overflow-y: hidden;
			white-space: nowrap;
			-webkit-overflow-scrolling: touch;
			padding: 1rem;
		}

		.houseCard{
			width: 90%;
			display: inline-block;
			padding: 1rem;
			margin: 0 1rem;
			background-color: white;
			border-radius: 0.5rem;
		}

	}


</style>


<div class="houseMainWrapper">

</div>


<script type="text/javascript">
	
	var farmId = '<?php echo $farm_id ?>';
	var recordObj = {};
	var houseList = window._dashboard.farm_list[farmId].house_list;

	for(var obj in window._dashboard.farm_list){

		for(var k=0;k<window._dashboard.farm_list[obj].cycle_list.length;k++){

			var currentBatchList = window._dashboard.farm_list[obj].cycle_list[k].batch_list;

			for(var i=0;i<currentBatchList.length;i++){

				for(var j=0;j<currentBatchList[i].batch_record.length;j++){

					if(typeof(recordObj[currentBatchList[i].batch_record[j].bird_house_id]) === 'undefined'){
						var recordArray = [];

						recordObj[currentBatchList[i].batch_record[j].bird_house_id] = recordArray;

						recordObj[currentBatchList[i].batch_record[j].bird_house_id].push(currentBatchList[i].batch_record[j]);
					} else{
						recordObj[currentBatchList[i].batch_record[j].bird_house_id].push(currentBatchList[i].batch_record[j]);

					}
				}
			}


		}

		
	}

	console.log(recordObj);

	console.log(houseList);

	var recordTableBody = document.createElement('TBODY');


	for(var i=0;i<houseList.length;i++){

		for(var obj in recordObj){

			if(Number(houseList[i].house_id) == Number(obj)){

				var currentRecord = recordObj[obj];				

				for(var j=0;j<currentRecord.length;j++){	
					$(recordTableBody).append('<tr> <td>'+currentRecord[j].bird_record_date+'</td> <td>'+currentRecord[j].bird_death+'</td> <td>'+currentRecord[j].bird_cull+'</td> <td>'+currentRecord[j].bird_catch+'</td> <td>'+currentRecord[j].bird_balance+'</td> </tr>');
				}

				break;

			}


		}

		$('.houseMainWrapper').append('	<div class="shadow houseCard"> <div class="row"> <div class="col-8 d-flex flex-column justify-content-start align-items-start"> <h5 style="margin:0;">'+houseList[i].house_name+'</h5><h6 style="margin:0;">'+getCategoryDesc("house_status",houseList[i].house_status)+'</h6> </div> <div class="col-4 d-flex justify-content-end align-items-center"> <div class="dropdown"> <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <p style="padding: 0;margin: 0;font-size: 1.3rem;display: inline;"><i class="fa fa-cog"></i></p> </button> <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"> <a class="dropdown-item houseEditButton" href="#" house_id='+houseList[i].house_id+'>Edit House</a> </div> </div> </div> </div> <div id="houseChartDiv"> <canvas id="houseCanvas'+houseList[i].house_id+'"></canvas></div> <div style="margin: 1rem 0;"> <div class="row"> <div class="col-9"> <h6>Capacity</h6> <h4>'+houseList[i].house_used_capacity+'/'+houseList[i].house_capacity+'</h4> </div> <div class="col-3 d-flex justify-content-center align-items-center"> <div style="padding: 0 0 0.5rem 0;"> </div> </div> </div> <div class="progress"> <div class="progress-bar" role="progressbar" style="width: '+((houseList[i].house_used_capacity/houseList[i].house_capacity) * 100)+'%;" aria-valuenow="'+((houseList[i].house_used_capacity/houseList[i].house_capacity) * 100)+'" aria-valuemin="0" aria-valuemax="100"></div> </div> </div> <h4>Records</h4> <div style="margin: 15px 0;position:relative;overflow:auto;height:200px;display:block;"><div class="table-responsive" style="height:100%;overflow-y:scroll;"> <table class="table"> <thead> <tr> <th>Date</th> <th>Death</th> <th>Cull</th> <th>Catch</th> <th>Bal.</th> </tr> </thead> '+$(recordTableBody).html()+' </table> </div> </div> </div>');


		var dateArr = [];
        var batchNameArr = [];
        var birdDeathArr = [];
        var birdCatchArr = [];
        var birdCullArr = [];
        var birdBalanceArr = [];

        if(typeof(window.houseAnalytics[houseList[i].house_id])!= 'undefined'){
	        if(typeof(window.houseAnalytics[houseList[i].house_id]['chart']) != 'undefined'){
		        var batchData = window.houseAnalytics[houseList[i].house_id]['chart'];

		        for(var obj in batchData){
		            dateArr.push(obj);
		            birdDeathArr.push(batchData[obj].bird_death);
		            birdCullArr.push(batchData[obj].bird_cull);
		            birdCatchArr.push(batchData[obj].bird_catch);
		            birdBalanceArr.push(batchData[obj].bird_balance);         
		        }

		        var data = {
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
		        }
	        }else{
	        	var data = {
		        datasets: [
		        {
		            label: 'Death',
		            data: [0],
		            fill: false
		        },
		        {
		            label: 'Cull',
		            data: [0],
		            fill: false
		        },
		        {
		            label: 'Catch',
		            data: [0],
		            fill: false
		        },
		        {
		            label: 'Balance',
		            data: [0],
		            fill: false,
		            hidden: true
		        }]
		        }
	        }

        }else{
        	var data = {
	        datasets: [
	        {
	            label: 'Death',
	            data: [0],
	            fill: false
	        },
	        {
	            label: 'Cull',
	            data: [0],
	            fill: false
	        },
	        {
	            label: 'Catch',
	            data: [0],
	            fill: false
	        },
	        {
	            label: 'Balance',
	            data: [0],
	            fill: false,
	            hidden: true
	        }]
	        }
        }



     	var ctx = $("#houseCanvas"+houseList[i].house_id).get(0).getContext("2d");
        var myChart = new Chart(ctx, {
          type: 'line',
          data: data
         });


	}

	$(document).on('click','.houseEditButton',function(){

		var house_id = $(this).attr('house_id');

		for(var i=0;i<houseList.length;i++){
			if(house_id == houseList[i].house_id){
				$('#houseEditForm').find('[name="house_name"]').val(houseList[i].house_name);
				$('#houseEditForm').find('[name="house_cat"]').val(houseList[i].house_cat);
				$('#houseEditForm').find('[name="house_capacity"]').val(houseList[i].house_capacity);
				$('#houseEditForm').find('[name="house_status"]').val(houseList[i].house_status);
				$('#houseEditForm').find('[name="house_farm_id"]').val(houseList[i].house_farm_id);
				$('#houseEditForm').find('[name="house_capacity"]').attr('min',Number(houseList[i].house_used_capacity));
				$('#houseEditForm').find('[name="house_id"]').val(houseList[i].house_id);
				break;
			}
		}

		

		$('#houseEditModal').modal('show');
		$('#houseEditForm').find('input').removeAttr('disabled');
        $('#houseEditForm').find('textarea').removeAttr('disabled');
        $('#houseEditForm').find('select').removeAttr('disabled');
        $('#houseEditConfirm').removeAttr('disabled');
        $('#houseEditConfirm').html('Edit');
		
	});

	$(document).on('click','#houseEditConfirm',function(){

		validateForm('houseEditForm');

	})

	$(document).ready(function() {
	    $(".dropdown-toggle").dropdown();
	});





</script>