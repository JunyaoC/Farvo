<?php

	session_start();

    include('assets/php/dbconnect.php');

    $user_id = $_SESSION['user_id'];    
    $company_id = $_GET['company'];

    if(!isset($user_id)){
        header('Location: index.php?code=2');
    }

    $sql = "SELECT * FROM tb_access
        JOIN tb_company ON tb_company.company_id = tb_access.access_company_id
        WHERE access_user_id = '$user_id' AND access_company_id = '$company_id'";

    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);

    $_SESSION['accessLevel'] = $row['access_level'];

    $found_company_id = $row['company_id'];
    $access_level = $_SESSION['accessLevel'];
    $farmCount = 0;
    $projectCount = 0;

    date_default_timezone_set("Asia/Kuala_Lumpur");

    if(!$found_company_id){
        header('Location: company.php?denied=1');
    }

    mysqli_close($con);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>FARVO</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cabin">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/material-icons.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/styles3.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-colorschemes"></script>
    


<!--     <script src="https://www.gstatic.com/firebasejs/7.5.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.5.2/firebase-database.js"></script>
    <script>
      // Your web app's Firebase configuration
      var firebaseConfig = {
        apiKey: "AIzaSyDX9G6uN5U5BEJSjVq0UIxc7FGkvOk_ucM",
        authDomain: "farvo-firebase.firebaseapp.com",
        databaseURL: "https://farvo-firebase.firebaseio.com",
        projectId: "farvo-firebase",
        storageBucket: "farvo-firebase.appspot.com",
        messagingSenderId: "275279405820",
        appId: "1:275279405820:web:971aa3bc8ca0bb1f6a2d79",
        measurementId: "G-N8TZ41NG86"
      };
      // Initialize Firebase
      firebase.initializeApp(firebaseConfig);
    </script> -->

    <script src="assets/js/farmerDashboardObject.js"></script>


</head>
<body>

    <style type="text/css">
        .lds-ring {
          display: inline-block;
          position: relative;
          width: 80px;
          height: 80px;
        }

        .lds-ring div {
          box-sizing: border-box;
          display: block;
          position: absolute;
          width: 64px;
          height: 64px;
          margin: 8px;
          border: 8px solid #000;
          border-radius: 50%;
          animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
          border-color: #000 transparent transparent transparent;
        }
        .lds-ring div:nth-child(1) {
          animation-delay: -0.45s;
        }
        .lds-ring div:nth-child(2) {
          animation-delay: -0.3s;
        }
        .lds-ring div:nth-child(3) {
          animation-delay: -0.15s;
        }
        @keyframes lds-ring {
          0% {
            transform: rotate(0deg);
          }
          100% {
            transform: rotate(360deg);
          }
        }
    </style>

    <div class="dashboardWrapper">
        <div class="dashboardNavigate"></div>
    	<div class="dashboardBody">        
    		<div class="sidebarWrapper">
    			<div id="farmLeftPanel">
                    <div style="min-height: 22vh;padding: 15px;">
                        <h1 class="text-center" style="font-family: Cabin, sans-serif;font-weight: bold;font-size: 1rem;color: rgb(71,74,77);">FARVO</h1>
                        <h1 class="text-center" style="font-family: Cabin, sans-serif;font-weight: bold;font-size: 1.5rem;color: rgb(71,74,77);padding: 10px;"><?php echo $row['company_name']; ?></h1>
                        <div class="row" style="margin: 0;padding: 1rem 0;">
                            <div class="col-3 col-xl-3 d-xl-flex flex-column justify-content-xl-center"><i class="far fa-building d-lg-flex justify-content-lg-center companyIcon panelIcon" style="font-size: 20px;"></i>
                                <p class="d-lg-flex justify-content-lg-center align-items-lg-center" style="font-size: 1rem;width: 100%;font-family: Cabin, sans-serif;font-weight: bold;"></p>
                            </div>
                            <div class="col-3 d-xl-flex flex-column justify-content-xl-center"><i class="fas fa-door-open d-lg-flex justify-content-lg-center panelIcon signoutIcon" style="font-size: 20px;"></i>
                                <p class="text-center d-lg-flex justify-content-lg-center" style="font-size: 1rem;width: 100%;font-family: Cabin, sans-serif;font-weight: bold;"></p>
                            </div>
                        </div>              
                    </div>
                    <div class="row">
                        <div class="col-md-9 col-sm-12">
                            <div class="shadow farmRowHead" style="background-color: rgb(63,39,213);color: white;">
                                <div class="row" style="width: 100%;margin: 0;">
                                    <div class="col d-flex align-items-center">
                                        <p class="text-left" style="margin: 0 0 0 -1rem;font-family: Cabin, sans-serif;font-weight: 900;font-size: 27px;">Batch</p>
                                    </div>                               
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    		</div>
    		<div class="mainContent">            
    			<div class="mainContentDiv">
                    <div class="mainContentHead" style="padding: 0.5rem;">
                        <div class="row" style="width: 100%;margin:0;"> <!-- header -->
                            <div class="col-5 d-flex justify-content-start align-items-center">
                                <p style="font-family: Cabin, sans-serif;font-weight: 900;font-size: 1.2rem;margin: 0;">FARVO</p>
                            </div>
                            <div class="col-7">
                                <div class="row d-flex justify-content-end">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button class="btn btn-outline-primary toggleSide" data-toggle="tooltip" data-placement="top" title="Show Farms"><i class="fas fa-bars"></i></button>
                                    </div>
                                </div>                                
                            </div>                            
                        </div>                 
                    </div>
                    <div class="batchCardDiv">
                        <div style="width:100%;padding-top:3rem;display:flex;justify-content:center;"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>
                    </div>

   				
    				
    			</div>
                <div class="mainContentCover toggleSide"></div>
    		</div>
    	</div>
    </div>
    





    <div class="detailBackground"></div>
    <div class="detailWrapper">
        <div class="detailContent">
            <div class="detailBody"></div>
        </div>
    </div>




    <div class="modal fade" role="dialog" tabindex="-1" id="addBatchRecord">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Record</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <p class="addProjectRecordDisplayDate" >Date: </p>
                    <form method="POST" action="php/batchRecord.php" id="addBatchRecordForm">
                        <div class="row" id="batchRecord"></div>

                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="addBatchRecordConfirm">Add</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="addEventModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Event</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <h4 class="eventModalDate"></h4>
                    <form method="POST" action="php/eventAdd.php" id="addEventForm">
                        <label>Event Type:</label>
                         <select class="form-control" name="event_type">
                        </select>
                        <div class="form-group">
                            <label for="event_note">Remarks:</label>
                            <textarea class="form-control" rows="5" id="event_note" placeholder="Remarks or description for the event" name="event_note"></textarea>
                        </div>
                        <input type="hidden" name="event_date" value="">
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="addEventConfirm">Add</button></div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        if(window._dashboard == null){
            window._dashboard = new farmer_dashboard('<?php echo $company_id ?>','<?php echo $access_level ?>','<?php echo $_SESSION['user_id'] ?>');

        }

        window.accessLevel = 1;
   	

        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })

        

        $(document).on('click','.farmRow',function(){
            $('.farmRow').removeClass('farmRowActive');
            $(this).addClass('farmRowActive');
        });

        //////modal functions




    	//////decoration functions

    	var sidewidth = $('.sidebarWrapper').width();
    	var viewportWidth = $(window).width();

    	if(viewportWidth < 600){
            $('.toggleSide').css('display','');
            var dashboardWidth = Number(sidewidth) + Number(viewportWidth);

            console.log(sidewidth,viewportWidth,dashboardWidth);
            $('.dashboardBody').width(dashboardWidth);
    		toggleSide();
    	}else{
            $('.toggleSide').css('display','none');
            $('.costTableDiv').height($('.costTableDiv').parent().height());
            $('#batchList').height($('#batchList').parent().height());
        }


    	
    	$('.toggleSide').on('click',function(){
    		toggleSide();
    	});

    	function toggleSide(){           

            if(viewportWidth < 600){

                 sidewidth = $('.sidebarWrapper').width();
                dashboardWidth = Number(sidewidth) + Number(viewportWidth);
                $('.dashboardBody').width(dashboardWidth);


        		$('.dashboardBody').toggleClass('hide');
        		if($('.dashboardBody').hasClass('hide')){
    	    		var left = $('.sidebarWrapper').width();
        			left = '-' + left + 'px';
        			console.log(left);
        			$('.dashboardBody').css('left', left);
                    $('.mainContentCover').css('zIndex','-100');
        		}else{
        			$('.dashboardBody').css('left', '0');
                    $('.mainContentCover').css('zIndex','100');
        		}
            }
    	}




        $(document).on('click','.detailTrigger',function(){
          
            var detail_id = $(this).attr('detail_id');

            $('.batchCardDiv').empty();
            $('.batchCardDiv').html('<div style="width:100%;padding-top:3rem;display:flex;justify-content:center;"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>');


            if(viewportWidth<600){
                var contentPage = 'detailBatchMobile.php';
            }else{
                var contentPage = 'detailBatch.php';
            }

            $.ajax({
                url:contentPage,
                type: 'POST',
                data:{'detail':detail_id}
            }).done(function(data){
                $('.batchCardDiv').empty();
                $('.batchCardDiv').html(data);
                $('.timelineDiv').css('top',($('.mainContentHead').outerHeight() + $('#nav-tab').outerHeight()) + 'px');
                $('#nav-analytics-tab').remove();
                $('#timelineCol').attr('class','col');
                $('#analyticCol').remove();
                $('.stopBatch').remove();
                $('#addEventButton').remove();
            })


        })
       



        //// utility

        function guid() {
          function s4() {
            return Math.floor((1 + Math.random()) * 0x10000)
              .toString(16)
              .substring(1);
          }
          return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
            s4() + '-' + s4() + s4() + s4();
        }

        ////// panel icon

        $('.companyIcon').on('click',function(){
            window.location.href = 'company.php';
        });

        $('.signoutIcon').on('click',function(){
            window.location.href = 'assets/php/userLogoutProc.php';
        })

        ////// analytics

        function generateAnalytics(){

            var batchData = {};
            var houseData = {};
            var houseWeightBatch = {};
            var costData = {};

            for(var obj in window._dashboard.farm_list){
                
                var currentFarmActiveCycle = window._dashboard.farm_list[obj].active_cycle_id;       /////active cycle

                for(var z=0;z<window._dashboard.farm_list[obj].cycle_list.length;z++){

                    if(window._dashboard.farm_list[obj].cycle_list[z].cycle_id == currentFarmActiveCycle){

                        var activeCycleBatchList = window._dashboard.farm_list[obj].cycle_list[z].batch_list;  ////batch list level
                   
                        for(var i=0;i<activeCycleBatchList.length;i++){ ////for each of the batch 

                            var currentBatchUid = activeCycleBatchList[i].batch_uid;
                            var currentBatchName = activeCycleBatchList[i].batch_name;
                            var batchRecord = activeCycleBatchList[i].batch_record;

                            var currentHouseArr = [];
                            var initBird = 0;

                            var date1 = new Date(activeCycleBatchList[i].batch_date);
                            var endDate = new Date(activeCycleBatchList[i].batch_date);
                            var endDateString = '';

                            for(var k=0;k<batchRecord.length;k++){

                                if(currentHouseArr.indexOf(batchRecord[k].bird_house_id) == -1){    //determine how many houses there are
                                    currentHouseArr.push(batchRecord[k].bird_house_id);
                                }

                                // console.log('!',houseDataStructure);
                                var house_id = batchRecord[k].bird_house_id;
                                // houseData[house_id.toString()] = houseDataStructure;

                                var date2 = new Date(batchRecord[k].bird_record_date); //determine what is the last recorded date
                                if(date2 > endDate){
                                    endDate = date2;
                                    endDateString = batchRecord[k].bird_record_date;
                                }
                            }

                            for(var k=0;k<currentHouseArr.length;k++){
                                initBird = initBird + Number(batchRecord[k].bird_balance);
                            }

                            // console.log('***',houseData);
                
                            var recordedHouseDataCount = 0;

                            var tempDeath ={}
                            var tempCull ={}
                            var tempCatch ={}  
                            var tempBalance ={}
                            var tempChart = {};

                            var batchTempDeath = 0;
                            var batchTempCull = 0;                 
                            var batchTempCatch = 0;
                            var batchTempBalance = 0;
                            var batchTempTotalWeight = 0;
                            var batchTempChart = {};
                            
                            for(var k=currentHouseArr.length;k<batchRecord.length;k++){  ///for each batch record
                             
                                batchTempDeath = batchTempDeath + Number(batchRecord[k].bird_death);
                                batchTempCull = batchTempCull + Number(batchRecord[k].bird_cull);
                                batchTempCatch = batchTempCatch + Number(batchRecord[k].bird_catch);
                                
                                if(typeof(tempDeath[batchRecord[k].bird_house_id]) == 'undefined'){
                                    tempDeath[batchRecord[k].bird_house_id] = Number(batchRecord[k].bird_death);
                                }else{
                                    tempDeath[batchRecord[k].bird_house_id] = Number(batchRecord[k].bird_death) + Number(tempDeath[batchRecord[k].bird_house_id]);
                                }

                                if(typeof(tempCull[batchRecord[k].bird_house_id]) == 'undefined'){
                                    tempCull[batchRecord[k].bird_house_id] = Number(batchRecord[k].bird_cull);
                                }else{
                                    tempCull[batchRecord[k].bird_house_id] = Number(batchRecord[k].bird_cull) + Number(tempCull[batchRecord[k].bird_house_id]);
                                }

                                if(typeof(tempCatch[batchRecord[k].bird_house_id]) == 'undefined'){
                                    tempCatch[batchRecord[k].bird_house_id] = Number(batchRecord[k].bird_catch);
                                }else{
                                    tempCatch[batchRecord[k].bird_house_id] = Number(batchRecord[k].bird_catch) + Number(tempCatch[batchRecord[k].bird_house_id]);
                                }

                                // if(typeof(tempBalance[batchRecord[k].bird_house_id]) == 'undefined'){
                                //     tempBalance[batchRecord[k].bird_house_id] = Number(batchRecord[k].bird_balance);
                                // }else{
                                //     tempBalance[batchRecord[k].bird_house_id] = Number(batchRecord[k].bird_balance);
                                // }

                                if(typeof(tempChart[batchRecord[k].bird_house_id]) == 'undefined'){

                                        tempChart[batchRecord[k].bird_house_id] = {
                                            [batchRecord[k].bird_record_date] : {
                                                bird_death: Number(batchRecord[k].bird_death),
                                                bird_cull: Number(batchRecord[k].bird_cull),
                                                bird_catch: Number(batchRecord[k].bird_catch),
                                                bird_balance: Number(batchRecord[k].bird_balance)
                                            }
                                        }
                                        
                                } else{
                                    if(typeof(tempChart[batchRecord[k].bird_house_id][batchRecord[k].bird_record_date])== 'undefined'){
                                        tempChart[batchRecord[k].bird_house_id][batchRecord[k].bird_record_date] = {
                                             
                                                bird_death: Number(batchRecord[k].bird_death),
                                                bird_cull: Number(batchRecord[k].bird_cull),
                                                bird_catch: Number(batchRecord[k].bird_catch),
                                                bird_balance: Number(batchRecord[k].bird_balance)
                                            
                                        }

                                    }else{
                                        tempChart[batchRecord[k].bird_house_id][batchRecord[k].bird_record_date].bird_death = tempChart[batchRecord[k].bird_house_id][batchRecord[k].bird_record_date].bird_death + Number(batchRecord[k].bird_death);
                                        tempChart[batchRecord[k].bird_house_id][batchRecord[k].bird_record_date].bird_cull = tempChart[batchRecord[k].bird_house_id][batchRecord[k].bird_record_date].bird_cull + Number(batchRecord[k].bird_cull);
                                        tempChart[batchRecord[k].bird_house_id][batchRecord[k].bird_record_date].bird_catch = tempChart[batchRecord[k].bird_house_id][batchRecord[k].bird_record_date].bird_catch + Number(batchRecord[k].bird_catch);
                                        tempChart[batchRecord[k].bird_house_id][batchRecord[k].bird_record_date].bird_balance = tempChart[batchRecord[k].bird_house_id][batchRecord[k].bird_record_date].bird_balance + Number(batchRecord[k].bird_balance);

                                    }
                                        
                                }

                                if(typeof(batchTempChart[batchRecord[k].bird_record_date]) == 'undefined'){
                                    batchTempChart[batchRecord[k].bird_record_date] = {
                                        bird_death: Number(batchRecord[k].bird_death),
                                        bird_cull: Number(batchRecord[k].bird_cull),
                                        bird_catch: Number(batchRecord[k].bird_catch),
                                        bird_balance: Number(batchRecord[k].bird_balance)
                                    }
                                }else{
                                    batchTempChart[batchRecord[k].bird_record_date].bird_death = batchTempChart[batchRecord[k].bird_record_date].bird_death + Number(batchRecord[k].bird_death);
                                    batchTempChart[batchRecord[k].bird_record_date].bird_cull = batchTempChart[batchRecord[k].bird_record_date].bird_cull + Number(batchRecord[k].bird_cull);
                                    batchTempChart[batchRecord[k].bird_record_date].bird_catch = batchTempChart[batchRecord[k].bird_record_date].bird_catch + Number(batchRecord[k].bird_catch);
                                    batchTempChart[batchRecord[k].bird_record_date].bird_balance = batchTempChart[batchRecord[k].bird_record_date].bird_balance + Number(batchRecord[k].bird_balance);
                                }


                                if(typeof(batchRecord[k].bird_weight) != 'undefined'){
                                    houseWeightBatch[batchRecord[k].bird_batch_uid] = {
                                        [batchRecord[k].bird_house_id] : batchRecord[k].bird_weight
                                    }
                                }

                                if((batchRecord[k].bird_record_date == endDateString) && (recordedHouseDataCount < currentHouseArr.length)){

                                    batchTempBalance = batchTempBalance + Number(batchRecord[k].bird_balance);
                                    console.log('1~',batchTempBalance,Number(batchRecord[k].bird_balance))

                                    for(var obj in houseWeightBatch){
                                        if(obj == currentBatchUid){
                                            for(var house in houseWeightBatch[obj]){
                                                if(house == batchRecord[k].bird_house_id){
                                                    batchTempTotalWeight = batchTempTotalWeight + ( Number(batchRecord[k].bird_balance) * Number(houseWeightBatch[obj][house]));
                                                }
                                            }
                                        }
                                    }

                                    
                                    recordedHouseDataCount = recordedHouseDataCount + 1;
                                }

                            }   ///end batch record loop

                            var tempFeed = {};
                            var batchTempTotalFeed = 0;
                            var batchStockRecord = activeCycleBatchList[i].batch_stock_record;
                            for(var k=0;k<batchStockRecord.length;k++){
                                if(typeof(tempFeed[batchStockRecord[k].sr_house_id]) == 'undefined'){
                                    tempFeed[batchStockRecord[k].sr_house_id] = Number(batchStockRecord[k].sr_item_quantity);    
                                }else{
                                    tempFeed[batchStockRecord[k].sr_house_id] = Number(tempFeed[batchStockRecord[k].sr_house_id]) + Number(batchStockRecord[k].sr_item_quantity);
                                }
                                batchTempTotalFeed = batchTempTotalFeed + Number(batchStockRecord[k].sr_item_quantity);
                            }

                            var tempHouse = {};

                            for(var k=0;k<currentHouseArr.length;k++){

                                var birdObj = {
                                    total_bird_death : tempDeath[currentHouseArr[k]],
                                    total_bird_cull : tempCull[currentHouseArr[k]],
                                    total_bird_catch : tempCatch[currentHouseArr[k]],                                
                                }

                                tempHouse[currentHouseArr[k]] = {
                                    bird : birdObj,
                                    feed : tempFeed[currentHouseArr[k]],
                                    chart: tempChart[currentHouseArr[k]]
                                }

                                houseData[currentHouseArr[k]] = tempHouse[currentHouseArr[k]]
                            }

                            var batchBird = {
                                total_bird_death : batchTempDeath,
                                total_bird_cull : batchTempCull,
                                total_bird_catch : batchTempCatch,
                                bird_balance : batchTempBalance,
                                total_weight : batchTempTotalWeight
                            }

                            var timeDiff = Math.abs(date1.getTime() - endDate.getTime());
                            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                            var totalDays = diffDays + 1;                           

                            var fcr = batchTempTotalWeight/(batchTempTotalFeed * 50);
                            var pi = (((batchTempTotalWeight / batchTempBalance) * ((Number(initBird) - (Number(batchTempDeath) + Number(batchTempCull))) * 100)) / (fcr * Number(totalDays))) * 100;


                            batchData[currentBatchUid] = {
                                bird: batchBird,
                                feed: batchTempTotalFeed,
                                chart: batchTempChart,
                                days:totalDays,
                                fcr : fcr,
                                pi : pi,
                                initBird : initBird,
                                batch_name: currentBatchName
                            }


                        }

                        break;
                    }

                }


            }




            console.log('x',houseWeightBatch);
            console.log('h',houseData);
            console.log('b',batchData);


            window.houseAnalytics = houseData;
            window.batchAnalytics = batchData;
        }

        function farmerReset(batch_uid){
            window._dashboard.updateLeftPanelDOM();
        }



    </script>


</body>
</html>