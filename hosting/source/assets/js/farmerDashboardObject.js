if(typeof(window.farmer_dashboard) != 'function'){

	window.farmer_dashboard = class dashboard{

		constructor(_company_id,_access_level,user_id){
			this.user_id = user_id;
			this.company_id = _company_id;
			this.farm_list = {};
			this.access_level = Number(_access_level);
			this.view_farm_id = 'overall';
			this.generateDashboard();
		}

		generateDashboard(){





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

				$('.generatedRow').remove();

                for(var i=0;i<batchResponse.length;i++){
                    $('#farmLeftPanel').append(" <div class='row generatedRow'> <div class='col-11 d-flex justify-content-start'> <div class='farmRow detailTrigger' detail_id='"+batchResponse[i].batch_uid+"'> <p style='margin: 0;font-family: Cabin, sans-serif;font-weight: 900;'>"+batchResponse[i].batch_name+"</p> </div> </div> </div>");
                }

               

			$.ajax({
				url:'assets/php/probeFarm.php',
				type:'POST',
				data:{'user_id':this.user_id}
			}).done(function(data){

				var allowedFarm = JSON.parse(data);

				var newFarmList = {};

				for(var i=0;i<allowedFarm.length;i++){
					for(var obj in window._dashboard.farm_list){
						console.log(allowedFarm[i],obj)
						if(allowedFarm[i] == obj){
							 newFarmList[obj] = window._dashboard.farm_list[obj]
						}


					}


				}

				window._dashboard.farm_list = newFarmList;

				console.log(window._dashboard);

			 	generateAnalytics();
			 	if(Object.keys(window._dashboard.farm_list).length > 0){
			 		$($('.detailTrigger')[0]).click();
			 	}else{
			 		$('.batchCardDiv').html('<h3>No available batch.</h3>');
			 		$('.generatedRow').remove();
	                $('.stopBatch').remove();
                	$('.addEventButton').remove();
			 	}

			})
                

			});

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