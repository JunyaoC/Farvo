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

    if($_SESSION['accessLevel'] == 1){
        header('Location: farmerDashboard.php?company='.$company_id);
    }   

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
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-colorschemes"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.1/parsley.js"></script>
    


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

    <script src="assets/js/dashboardObject.js"></script>


</head>
<body>

    <div class="dashboardWrapper">
        <div class="dashboardNavigate d-flex justify-content-center" style="display: none;"></div>
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
                            <div class="col-3 d-xl-flex flex-column justify-content-xl-center"><i class="fas fa-user-friends d-lg-flex justify-content-lg-center panelIcon teamIcon detailTrigger" level="team" detail_id="<?php echo $found_company_id ?>" style="font-size: 20px;"></i>
                                <p class="text-center d-lg-flex justify-content-lg-center" style="font-size: 1rem;width: 100%;font-family: Cabin, sans-serif;font-weight: bold;"></p>
                            </div>
                            <div class="col-3 d-xl-flex flex-column justify-content-xl-center" style="font-size: 20px;"><i class="fas fa-file-alt d-lg-flex justify-content-lg-center panelIcon cycleListButton" style="font-size: 20px;"></i>
                                <p class="text-center d-lg-flex justify-content-lg-center" style="font-size: 1rem;width: 100%;font-family: Cabin, sans-serif;font-weight: bold;"></p>
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
                                        <p class="text-left" style="margin: 0 0 0 -1rem;font-family: Cabin, sans-serif;font-weight: 900;font-size: 27px;">Farms</p>
                                    </div>
                                    <?php
                                        if($_SESSION['accessLevel'] == 4){
                                            echo '<div class="col d-flex justify-content-end align-items-center"><i class="fas fa-plus d-xl-flex justify-content-xl-center align-items-xl-center" id="addFarmButton" style="font-size: 22px;color: rgb(52,52,52);"></i></div>';
                                        }
                                    ?>                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-11">
                            <div class="farmRow farmRowActive" farm_id='overall'>
                                <p style="margin: 0;font-family: Cabin, sans-serif;font-weight: 900;">Overall</p>
                            </div>
                        </div>
                    </div>
                </div>
    		</div>
    		<div class="mainContent">            
    			<div class="mainContentDiv">
    				<div class="mainContentHead">
    					<div class="row" style="width: 100%;margin:0;"> <!-- header -->
    						<div class="col-5">
    							<h6 id="farmNameDisplay" style="margin: 0;">Farm Name</h6>    
    							<h2 id="cycleNameDisplay">Cycle #</h2>
    						</div>
                            <div class="col-7">
                                <div class="row d-flex justify-content-sm-center justify-content-md-end align-items-center">
                                    <div class="col-3 col-md-2">
                                        <button class="btn btn-outline-primary toggleSide" data-toggle="tooltip" data-placement="top" title="Show Farms"><i class="fas fa-bars"></i></button>
                                    </div>
                                    <div class="col-3 col-md-2" id="cycleOperation">                                        
                                        <button class="btn btn-outline-primary stopCycle" data-toggle="tooltip" data-placement="top" title="Stop Cycle"><i class="fas fa-stop"></i></button>
                                    </div>
                                    <div class="col-3 col-md-2">
                                        <button class="btn btn-outline-primary reportButton" data-toggle="tooltip" data-placement="top" title="Generate Report"><i class="fas fa-pen"></i></button>
                                    </div>
                                </div>
                                
                            </div>
    						
    					</div>

    					
    					
    				</div>
                    <div class="row dashboardRow">
                        <div class="col-md-6 col-sm-12 dashboardCol">   <!-- livability stats -->
                            <div class="shadow dashboardCard">
                                <div class="d-flex justify-content-center dashboardCardHead">
                                    <h6 style="margin: 0;">Overview</h6>
                                </div>
                                    <div id="overviewChartDiv" style="width: 100%;height: 100%;">
                                        <canvas id="overviewChart"></canvas>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 dashboardCol">   <!-- batch directory -->
                            <div class="shadow dashboardCard">
                                <div class="d-flex justify-content-center dashboardCardHead">
                                    <h6 style="margin: 0;">Batch</h6>
                                </div>
                                <div id="batchList" style="overflow-y: scroll;height: 100%;margin: 0 -1rem 0 -1rem;"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 dashboardCol">   <!-- house -->
                            <div class="shadow dashboardCard">
                                <div class="d-flex justify-content-center dashboardCardHead">
                                    <h6 style="margin: 0;">House</h6>
                                </div>
                                <div class="houseList" style="overflow-y: scroll;height: 100%;margin: 0 -1rem 0 -1rem;padding: 1rem;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row dashboardRow">
                        <div class="col-md-3 col-sm-12 dashboardCol">   <!-- profit & loss -->
                            <div class="shadow dashboardCard">
                                <div class="d-flex justify-content-center dashboardCardHead">
                                    <h6 style="margin: 0;">Profit & Loss</h6>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <p>DOC, Feed Consumed & Medication</p>
                                        <h5 id="totalGrossCostDisplay">RM -</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <p>Total Cost</p>
                                        <h5 id="totalCostDisplay">RM -</h5>
                                    </div>
                                </div>
                                <a href="#" id="showPriceButton">Prices</a>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 dashboardCol">   <!-- cost table -->
                            <div class="shadow dashboardCard">
                                <div class="d-flex justify-content-center dashboardCardHead">
                                    <h6 style="margin: 0;">Cost Table</h6>
                                </div>
                                <div class="costTableDiv" style="overflow-y: scroll;"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 dashboardCol">   <!-- feed stock -->
                            <div class="shadow dashboardCard d-flex flex-column" style="height: 100%;">
                                <div class="d-flex justify-content-center dashboardCardHead">
                                    <h6 style="margin: 0;">Stock</h6>
                                </div>
                                <div id="stockList" style="height: 100%;"></div>
                            </div>
                        </div>
                    </div>
    				
    				
    			</div>
                <div class="mainContentCover toggleSide"></div>
                <div class="cycleInitCover">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">No Active Cycle</h5>
                            <p class="card-text">Please create a cycle in order to initialize batch.</p>
                            <a href="#" class="btn btn-primary cycleAddButton">Start</a>
                        </div>
                    </div>
                </div>
    		</div>
    	</div>
    </div>
    





    <div class="detailBackground"></div>
    <div class="detailWrapper">
        <div class="detailContent">
            <div class="detailBody"></div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="addFarmModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Farm</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <form method="POST" action="" id="farmAddForm">
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Farm Name" name="farm_name" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" placeholder="Address" name="farm_address" required></textarea>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="farm_cat">

                            </select>
                        </div>
                        <input type="hidden" name="farm_company_id" value="<?php echo $found_company_id; ?>">
                        <input type="hidden" name="new_dest" value="../companyDashboard.php?company=<?php echo $found_company_id; ?>">
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-primary" id="addFarmConfirm">Add</button></div>
            </div>
        </div>
    </div>

   <div class="modal fade" role="dialog" tabindex="-1" id="editFarmModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Farm</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <p>Some Important Instructions.</p>
                    <form method="POST" action="php/farmEdit.php" id="farmEditForm">
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Farm Name" name="edit_farm_name" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" placeholder="Address" name="edit_farm_address" required></textarea>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="edit_farm_cat"></select>
                        </div>
                        <input type="hidden" name="edit_farm_id">
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="editFarmConfirm">Edit</button></div>
            </div>
        </div>
    </div>


    <div class="modal fade" role="dialog" tabindex="-1" id="cycleAddModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Cycle</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <p>Some Important Instructions.</p>
                    <form method="POST" action="assets/php/cycleAdd.php" id="cycleAddForm">
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Cycle Name" name="cycle_name" required>
                        </div>                      
                        <div class="form-group">
                            <select class="form-control" name="cycle_farm_id"></select>
                        </div>
                        <input type="hidden" name="cycle_init_date" value="<?php echo date('Y-m-d') ?>">
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-primary" id="cycleAddConfirm">Start</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="batchAddModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Batch</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <form method="POST" action="assets/php/batchAdd.php" id="batchAddForm">
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Batch Name" name="batch_name" required>
                        </div> 
                        <div class="form-group">
                            <label>Price Per Bird</label>
                            <div class="row">
                                <div class="col-3 d-flex justify-content-right align-items-center">
                                    <p class="text-right" style="margin: 0;">RM</p>
                                </div>
                                <div class="col-9">
                                    <input class="form-control" type="number" placeholder="" step="0.01" name="batch_price_per_bird" min="0" required>
                                </div>                                
                            </div>                            
                        </div> 
                        <div class="form-group">
                            <select class="form-control" name="batch_type"></select>
                        </div>
                        <div id="initBatchHouseDiv"></div>
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="batchAddConfirm">Add</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="addHouseModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New House</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <p>Some Important Instructions.</p>
                    <form method="POST" action="assets/php/houseAdd.php" id="houseAddForm">
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="House Name" name="house_name" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="number" placeholder="House Capacity" name="house_capacity" min="0" required>
                        </div>
                        
                        <div class="form-group">
                            <select class="form-control" name="house_cat"></select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="house_status"></select>
                        </div>
                        <input type="hidden" name="house_farm_id">
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="addHouseConfirm">Add</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="stockAddFeedModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Feed</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <form method="POST" action="php/stockAddFeed.php" id="stockAddFeedForm">
                        <div id="addFeedDiv"></div>
                        <input type="hidden" name="stock_id" value="">
                    </form>
                    <div id="feedPriceTotal">
                        <h5>Total: RM0</h5>
                    </div>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="stockAddFeedConfirm">Add</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="addStockModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Feed Stock</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <p>Some Important Instructions.</p>
                    <form method="POST" action="assets/php/stockAdd.php" id="stockAddForm">
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Store Name" name="stock_name" required>
                        </div>
                        <input type="hidden" name="stock_farm_id" value="">
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="addStockConfirm">Add</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="addBatchRecord">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Record</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <p class="addProjectRecordDisplayDate" >Date: </p>
                    <h6 id="catchProfitDisplay"></h6>
                    <form method="POST" action="php/batchRecord.php" id="addBatchRecordForm">
                        <div class="row d-flex justify-content-center" id="batchRecord"></div>

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

    <div class="modal fade" role="dialog" tabindex="-1" id="addCostModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Cost</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <form method="POST" action="php/eventAdd.php" id="addCostForm">
                        <input type="hidden" name="cost_cycle_id">
                        <label>Date:</label>
                        <div class="form-group">
                            <input class="form-control" type="date" name="cost_date" required>
                        </div>
                        <label>Category:</label>
                        <div class="form-group">
                            <select class="form-control" name="cost_category"></select>
                        </div>                        
                        <div class="form-group">
                            <label for="cost_amount">Amount:</label>
                            <div class="row" style="margin: 0;">
                                <div class="col-3 d-flex justify-content-end align-items-center">
                                    <p style="margin: 0;">RM</p>
                                </div>
                                <div class="col-9">
                                    <input class="form-control" type="number" name="cost_amount" id="cost_amount" min="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cost_note">Remarks:</label>
                            <textarea class="form-control" rows="5" id="cost_note" placeholder="Remarks or description for the event" name="cost_note"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="addCostConfirm">Add</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="feedPriceModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Feed Price</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="php/feedPrice.php" id="feedPriceForm">
                        
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="feedPriceConfirm">Add</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="showPriceModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Prices</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="showPriceForm">
                        
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="showPriceConfirm">Ok</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="cycleListModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">View Cycle Report</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <p>Click to view report for each cycle.</p>
                    <div id="cycleListDiv"></div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>


    <div class="modal fade" role="dialog" tabindex="-1" id="batchStopModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Stop Batch</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <h5>No future changes can be made after stopping the batch, including reverting the batch itself back to active.</h5>
                    <p>Please enter final weight to stop the batch.</p>
                    <form method="POST" action="php/feedPrice.php" id="batchStopForm">
                        
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="batchStopConfirm">Ok</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmOptionModal" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Access</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <select class="form-control" id="confirmSelect">
                        <option value="2">Stakeholder</option>
                        <option value="4">Admin</option>
                        <option value="3">Staff</option>
                        <option value="1">Farmer</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary confirmEditAccess" data-dismiss="modal">Edit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="houseEditModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit House</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <p>Some Important Instructions.</p>
                    <form method="POST" action="assets/php/houseEdit.php" id="houseEditForm">
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="House Name" name="house_name" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="number" placeholder="House Capacity" name="house_capacity" min="0" required>
                        </div>
                        
                        <div class="form-group">
                            <select class="form-control" name="house_cat"></select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="house_status"></select>
                        </div>
                        <input type="hidden" name="house_farm_id">
                        <input type="hidden" name="house_id">
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-primary" id="houseEditConfirm">Add</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="manageFarmerModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Manage Farmer</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <p>Manage farmer's access to this farm.</p>
                    <form method="POST" action="" id="manageFarmerForm">
                        


                    </form>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">

    	if(window._dashboard == null){
            window._dashboard = new dashboard('<?php echo $company_id ?>','<?php echo $access_level ?>');
        }

        if(window.accessLevel == null){
            window.accessLevel = Number('<?php echo $_SESSION['accessLevel'] ?>');
        }

        if(window.accessLevel == 2){
            $('.cycleAddButton').remove();
            $('#cycleOperation').remove();
            $('#showPriceButton').remove();
        }

        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })

        

        $(document).on('click','.farmRow',function(){
            $('.farmRow').removeClass('farmRowActive');
            $(this).addClass('farmRowActive');

            $('.bufferDiv').html('<div class="lds-ring"><div></div><div></div><div></div><div></div></div>');
            $('.dashboardContent').css('display','none');

            window._dashboard.view_farm_id = $(this).attr('farm_id');
            $('[name="house_farm_id"]').val(window._dashboard.view_farm_id);
            $('[name="stock_farm_id"]').val(window._dashboard.view_farm_id);
            
            if(typeof(window.storeChart) === 'function'){
                window.storeChart.destroy();
            }

            if(window._dashboard.view_farm_id != 'overall'){
                $('.houseList').html(window._dashboard.farm_list[window._dashboard.view_farm_id].house_list_dom);
                $('#stockList').html(window._dashboard.farm_list[window._dashboard.view_farm_id].stock_list_dom);
                window._dashboard.farm_list[window._dashboard.view_farm_id].viewCycle();

                $('#batchList').empty();
                for(var j=0;j< window._dashboard.farm_list[window._dashboard.view_farm_id]['cycle_list'].length;j++){
                    if(window._dashboard.farm_list[window._dashboard.view_farm_id]['cycle_list'][j].cycle_id == window._dashboard.farm_list[window._dashboard.view_farm_id].active_cycle_id){
                        window._dashboard.farm_list[window._dashboard.view_farm_id]['cycle_list'][j].generateBatchDOM();
                        $('#batchList').html(window._dashboard.farm_list[window._dashboard.view_farm_id]['cycle_list'][j].batch_dom);
                    }
                }

                var totalCost = 0;
                var totalGPLCost = 0;

                $('.costTableDiv').empty();
                $('.costTableDiv').append('<table class="table"> <thead> <tr> <th scope="col">Date</th> <th scope="col">Category</th> <th scope="col">Remarks</th> <th scope="col">RM</th> </tr> </thead> <tbody id="costTableBody"> </tbody> </table>');

                for(var i=0;i<window._dashboard.farm_list[window._dashboard.view_farm_id]['cycle_list'].length;i++){

                    if(window._dashboard.farm_list[window._dashboard.view_farm_id].cycle_list[i].cycle_id == window._dashboard.farm_list[window._dashboard.view_farm_id].active_cycle_id){

                        var cycleCostArr = window._dashboard.farm_list[window._dashboard.view_farm_id].cycle_list[i].cycle_cost;

                        for(var j=0;j<cycleCostArr.length;j++){ ////need to make feed into 2 category - consumption and feed
                            if(getCategoryDesc('cost',cycleCostArr[j].cost_category) == 'day 0 chick' || getCategoryDesc('cost',cycleCostArr[j].cost_category) == 'medication & supplements'){
                                totalGPLCost = totalGPLCost + Number(cycleCostArr[j].cost_amount);
                            }

                            var costNote = cycleCostArr[j].cost_note;
                            costNote = costNote.split('\n').join('<br>');

                            $('#costTableBody').append('<tr> <td>'+cycleCostArr[j].cost_date+'</td> <td>'+getCategoryDesc('cost',cycleCostArr[j].cost_category)+'</td> <td>'+costNote+'</td> <td>'+cycleCostArr[j].cost_amount+'</td> </tr>');

                            totalCost = totalCost + Number(cycleCostArr[j].cost_amount);

                        }

                       
                        break;

                    }

                }

                $('#totalGrossCostDisplay').text('RM '+totalGPLCost);
                $('#totalCostDisplay').text('RM '+totalCost);

                    var dateArr = [];
                    var batchNameArr = [];
                    var birdDeathArr = [];
                    var birdCatchArr = [];
                    var birdCullArr = [];
                    var birdBalanceArr = [];

                    var totalObject = {};

                    for(var i=0;i<window._dashboard.farm_list[window._dashboard.view_farm_id]['cycle_list'].length;i++){
                        if(window._dashboard.farm_list[window._dashboard.view_farm_id].cycle_list[i].cycle_id == window._dashboard.farm_list[window._dashboard.view_farm_id].active_cycle_id){
                            
                            var batchList = window._dashboard.farm_list[window._dashboard.view_farm_id]['cycle_list'][i].batch_list;

                            for(var j=0;j<batchList.length;j++){

                                var currentBatchUid = batchList[j].batch_uid;

                                var chartArr = window.batchAnalytics[currentBatchUid]['chart'];                        

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


                            break;
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
                    overviewChartDOM.canvas.height = $('#overviewChartDiv').height();

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

            }else{
                $('.houseList').html(window._dashboard.overall('house'));
                $('#stockList').html(window._dashboard.overall('stock'));
                window._dashboard.overall('cycle');
                window._dashboard.overall('chart');
                $('.costTableDiv').html(window._dashboard.overall('cost'));
                $('#batchList').html(window._dashboard.overall('batch'));
            }


            $('.bufferDiv').empty();
            $('.dashboardContent').css('display','');

        });

        //////modal functions

        $(document).on('click','#addFarmButton',function(){
            $('#addFarmModal').modal('show');
            $('#farmAddForm').find('input').removeAttr('disabled');
            $('#farmAddForm').find('textarea').removeAttr('disabled');
            $('#farmAddForm').find('select').removeAttr('disabled');
            $('#addFarmConfirm').removeAttr('disabled');
            $('#addFarmConfirm').html('Add');
        })

        $('#addFarmConfirm').on('click',function(){

            validateForm('farmAddForm');

        })

        $(document).on('click','#editFarmButton',function(){

            var edit_farm_name = window._dashboard.farm_list[window._dashboard.view_farm_id].farm_name;
            var edit_farm_address = window._dashboard.farm_list[window._dashboard.view_farm_id].farm_address;
            var edit_farm_cat = window._dashboard.farm_list[window._dashboard.view_farm_id].farm_cat;
            var edit_farm_id = window._dashboard.farm_list[window._dashboard.view_farm_id].farm_id;


            $('#editFarmModal').modal('show');
            $('#farmEditForm').find('input').removeAttr('disabled');
            $('#farmEditForm').find('textarea').removeAttr('disabled');
            $('#farmEditForm').find('select').removeAttr('disabled');
            $('#editFarmConfirm').removeAttr('disabled');
            $('#editFarmConfirm').html('Add');

            $('[name="edit_farm_name"]').val(edit_farm_name);
            $('[name="edit_farm_address"]').val(edit_farm_address);
            $('[name="edit_farm_cat"]').val(edit_farm_cat);
            $('[name="edit_farm_id"]').val(edit_farm_id);
        });

        $('#editFarmConfirm').on('click',function(){

            validateForm('farmEditForm');

        })



        $(document).on('click','.cycleAddButton',function(){

            $('select[name="cycle_farm_id"]').empty();      /// attach farm list

            for(var obj in window._dashboard.farm_list){

                if(window._dashboard.farm_list[obj].active_cycle_id == -1){
                    var farmName = window._dashboard.farm_list[obj].farm_name;
                    var farmId = window._dashboard.farm_list[obj].farm_id;
                    $('select[name="cycle_farm_id"]').append('<option value="'+farmId+'">'+farmName+'</option>');
                }

            }           

            $('#cycleAddModal').modal('show');
            $('#cycleAddForm').find('input').removeAttr('disabled');
            $('#cycleAddForm').find('textarea').removeAttr('disabled');
            $('#cycleAddForm').find('select').removeAttr('disabled');
            $('#cycleAddConfirm').removeAttr('disabled');
            $('#cycleAddConfirm').html('Start');

        });

        $('#cycleAddConfirm').on('click',function(){
            validateForm('cycleAddForm');
        })

        $(document).on('click','#addBatchButton',function(){

            if(window._dashboard.farm_list[window._dashboard.view_farm_id].active_cycle_id < 0){
                alert('Please start a new cycle before creating a new batch.');
            }else{

                var activeHouse = false;

                if(window._dashboard.farm_list[window._dashboard.view_farm_id].house_list.length > 0){

                    $('select[name="batch_type"]').empty();      /// attach farm list

                    

                    for(var i=0;i<window.category.length;i++){

                        if(window.category[i].category_level == 'batch'){
                            var batch_desc = window.category[i].category_desc;
                            var batch_id = window.category[i].category_id;
                            $('select[name="batch_type"]').append('<option value="'+batch_id+'">'+batch_desc+'</option>');
                        }
                    }

                    $('#initBatchHouseDiv').empty();

                    for(var i=0;i<window._dashboard.farm_list[window._dashboard.view_farm_id].house_list.length;i++){

                        if(getCategoryDesc('house_status',window._dashboard.farm_list[window._dashboard.view_farm_id].house_list[i].house_status) == 'active'){

                            activeHouse = true;

                            var house_id = window._dashboard.farm_list[window._dashboard.view_farm_id].house_list[i].house_id;

                            var house_name = window._dashboard.farm_list[window._dashboard.view_farm_id].house_list[i].house_name;

                            var vacantCpacity = Number(window._dashboard.farm_list[window._dashboard.view_farm_id].house_list[i].house_capacity) - Number(window._dashboard.farm_list[window._dashboard.view_farm_id].house_list[i].house_used_capacity)

                            $('#initBatchHouseDiv').append('<div class="form-group"><div class="row"><div class="col-6 d-flex justify-content-center align-items-center flex-column"><h6 style="margin:0;">'+house_name+'</h6><p style="font-size:0.7rem;">Vacant capacity: '+vacantCpacity+'</p></div><div class="col-6 text-center"><p style="font-size:0.8rem;font-weight:900;font-family:Cabin;margin:0;">BIRD QUANTITY</p><div class="form-group"><input type="number" name="" house_id="'+house_id+'" class="house_bird_init_input form-control" value="0" min="0" max="'+vacantCpacity+'"></div></div></div></div>');                        
                        }
                    }           
                }

                if(activeHouse){
                    $('#batchAddModal').modal('show');
                    $('#batchAddForm').find('input').removeAttr('disabled');
                    $('#batchAddForm').find('textarea').removeAttr('disabled');
                    $('#batchAddForm').find('select').removeAttr('disabled');
                    $('#batchAddConfirm').removeAttr('disabled');
                    $('#batchAddConfirm').html('Start');
                }else{
                    alert('There is currently no active house in the farm. Please add house before creating a new batch.')

                }
            }



        });

       $('#batchAddConfirm').on('click',function(){
            
            validateForm('batchAddForm');                      

        })





        $(document).on('click','#addHouseButton',function(){
            $('#addHouseModal').modal('show');
            $('#houseAddForm').find('input').removeAttr('disabled');
            $('#houseAddForm').find('textarea').removeAttr('disabled');
            $('#houseAddForm').find('select').removeAttr('disabled');
            $('#addHouseConfirm').removeAttr('disabled');
            $('#addHouseConfirm').html('Add');
        })

       $('#addHouseConfirm').on('click',function(){
            validateForm('houseAddForm');
        })

       $(document).on('click','#addStockButton',function(){
            $('#addStockModal').modal('show');
            $('#stockAddForm').find('input').removeAttr('disabled');
            $('#stockAddForm').find('textarea').removeAttr('disabled');
            $('#stockAddForm').find('select').removeAttr('disabled');
            $('#addStockConfirm').removeAttr('disabled');
            $('#addStockConfirm').html('Add');
        })

       $('#addStockConfirm').on('click',function(){
            validateForm('stockAddForm');
        })




		$(document).on('click','.stockAddFeedButton',function(){

            if(window._dashboard.view_farm_id == 'overall'){
                alert("Please add stock in a farm. (Currently you are in Overall View)")
            }else{
    			$('#addFeedDiv').empty();      /// attach farm list
                var costCycleId = window._dashboard.farm_list[window._dashboard.view_farm_id].active_cycle_id;
                $('#stockAddFeedConfirm').attr('cycle_id',costCycleId);

                for(var i=0;i<window.category.length;i++){

                    if(window.category[i].category_level == 'feed'){
                        var feed_desc = window.category[i].category_desc;
                        var feed_id = window.category[i].category_id;

                        for(var j=0;j<window.category.length;j++){

                            if(window.category[j].category_code == feed_id && window.category[j].category_level == 'feed_price'){

                                var feed_price = window.category[j].category_desc;

                                $('#addFeedDiv').append('<div class="form-group"><div class="row"><div class="col-6 d-flex justify-content-center align-items-center flex-column"><h6>'+feed_desc+'</h6><p>RM '+feed_price+' per bag</p></div><div class="col-6 text-center"><p style="font-size:0.8rem;font-weight:900;font-family:Cabin;margin:0;">BAGS</p><div class="form-group"><input type="number" min="0" feed_id="'+feed_id+'" class="stock_add_feed_input form-control" value="0" required></div></div></div></div>');

                                break;


                            }

                        }

                        
                    }
                }

                console.log($(this).attr('stock_id'));
                $('input[name="stock_id"]').val($(this).attr('stock_id'));


    			$('#stockAddFeedModal').modal('show');
                $('#stockAddFeedForm').find('input').removeAttr('disabled');
                $('#stockAddFeedForm').find('textarea').removeAttr('disabled');
                $('#stockAddFeedForm').find('select').removeAttr('disabled');
                $('#stockAddFeedConfirm').removeAttr('disabled');
                $('#stockAddFeedConfirm').html('Add');

            }

		})

        $(document).on('input','.stock_add_feed_input',function(){

            var totalPrice = 0;


            var priceArr = [];

            for(var i=0;i<window.category.length;i++){
                if(window.category[i].category_level == 'feed'){

                    var feed_id = window.category[i].category_id;

                    for(var j=0;j<window.category.length;j++){

                        if(window.category[j].category_code == feed_id){
                            priceArr.push({
                                feed_id: feed_id,
                                price: window.category[j].category_desc
                            })
                        }

                    }

                }
            }

            console.log(priceArr);

            for(var i=0;i<priceArr.length;i++){

                var currentValue = Number($('.stock_add_feed_input[feed_id="'+priceArr[i].feed_id+'"]').val());
                console.log(currentValue);
                totalPrice = totalPrice + (currentValue * priceArr[i].price);
            }

            $('#feedPriceTotal').text('Total: RM ' +totalPrice);



        });


		$(document).on('click','#stockAddFeedConfirm',function(){
			
            validateForm('stockAddFeedForm');

		})

        $(document).on('click','#addCostButton',function(){

            $('[name="cost_cycle_id"]').val(window._dashboard.farm_list[window._dashboard.view_farm_id].active_cycle_id);

            $('#addCostModal').modal('show');
            $('#addCostForm').find('input').removeAttr('disabled');
            $('#addCostForm').find('textarea').removeAttr('disabled');
            $('#addCostForm').find('select').removeAttr('disabled');
            $('#addCostConfirm').removeAttr('disabled');
            $('#addCostConfirm').html('Add');
        })

        $('#addCostConfirm').on('click',function(){

            validateForm('addCostForm');

        })

        $(document).on('click','#showPriceButton',function(){

            $('#showPriceForm').empty();

            for(var i=0;i<window.category.length;i++){

                if(window.category[i].category_level == 'batch'){

                    var batch_cat_id = window.category[i].category_id;
                    var batch_desc = window.category[i].category_desc;
                    var batch_price = "";

                    for(var j=0;j<window.category.length;j++){

                        if(window.category[j].category_level == 'batch_price' && batch_cat_id == window.category[j].category_code){

                            batch_price = window.category[j].category_desc;                           

                        }
                    }

                    $('#showPriceForm').append('<div class="row"> <div class="col-6"> <h6 style="margin: 0;">'+batch_desc+'</h6> </div> <div class="col-2"> <p style="margin: 0;">RM</p> </div> <div class="col-4"> <div class="form-group"> <input class="form-control batchPriceInput" batch_cat_id="'+batch_cat_id+'" type="number" step="0.01" required name="" value="'+batch_price+'"> </div> </div> </div>');

                }
            }


            $('#showPriceModal').modal('show');
            $('#showPriceForm').find('input').removeAttr('disabled');
            $('#showPriceForm').find('textarea').removeAttr('disabled');
            $('#showPriceForm').find('select').removeAttr('disabled');
            $('#showPriceConfirm').removeAttr('disabled');
            $('#showPriceConfirm').html('Add');
        })

        $('#showPriceConfirm').on('click',function(){

            validateForm('showPriceForm');   

        })

        $('.reportButton').on('click',function(){

            if(window._dashboard.view_farm_id != 'overall'){
                window.location.href = "report.php?cycle_id="+window._dashboard.farm_list[window._dashboard.view_farm_id].active_cycle_id;
            } else{
                $('#cycleListDiv').empty();

                for(var obj in window._dashboard.farm_list){
                    for(var i=0;i<window._dashboard.farm_list[obj].cycle_list.length;i++){

                        $('#cycleListDiv').append('<p><a href="report.php?cycle_id='+window._dashboard.farm_list[obj].cycle_list[i].cycle_id+'">'+window._dashboard.farm_list[obj].cycle_list[i].cycle_name+'</a></p>');

                    }

                }
                $('#cycleListModal').modal('show');
            }

        })

        $('.cycleListButton').on('click',function(){
            $('#cycleListDiv').empty();

            for(var obj in window._dashboard.farm_list){
                for(var i=0;i<window._dashboard.farm_list[obj].cycle_list.length;i++){

                    $('#cycleListDiv').append('<p><a href="report.php?cycle_id='+window._dashboard.farm_list[obj].cycle_list[i].cycle_id+'">'+window._dashboard.farm_list[obj].cycle_list[i].cycle_name+'</a></p>');

                }

            }

            $('#cycleListModal').modal('show');

        })

        $(document).on('click','.stopCycle',function(){

            if(window._dashboard.view_farm_id == 'overall'){

            } else{
                
                var targetCycle = window._dashboard.farm_list[window._dashboard.view_farm_id].active_cycle_id;

                var cycleList = window._dashboard.farm_list[window._dashboard.view_farm_id].cycle_list;

                var activeBatch = false;
                
                for(var i=0;i<cycleList.length;i++){

                    if(cycleList[i].cycle_id == targetCycle){

                        var batchList =cycleList[i].batch_list;

                        for(var j=0;j<batchList.length;j++){

                            if(getCategoryDesc('batch_status',batchList[j].batch_status) == 'active'){
                                activeBatch = true;
                            }
                           

                        }

                    

                    }

                


                }
                if(activeBatch){
                    alert("There's still active batch. Please marked each batch complete before stopping the cycle.");
                }else{
                    if(confirm('Are you sure you want to stop cycle?')){

                        document.write('Stopping cycle...');

                        $.ajax({
                            url:'assets/php/cycleStop.php',
                            type: 'POST',
                            data: {'cycle_id':window._dashboard.farm_list[window._dashboard.view_farm_id].active_cycle_id,'cycle_status':getCategoryCode('cycle_status','completed')}
                        }).done(function(data){
                            window.location.reload();
                        })

                    }
                }
            }


        });

        $(document).on('click','.manageFarmer',function(){

            var farmAccessArr = window._dashboard.farm_list[window._dashboard.view_farm_id].farm_access;

            $('#manageFarmerForm').empty();

            for(var i=0;i<farmAccessArr.length;i++){

                    if(farmAccessArr[i].access == '1'){
                        $('#manageFarmerForm').append('<div class="form-group"> <div class="row"> <div class="col-8"> <h6>✔'+farmAccessArr[i].user_name+'</h6> <p style="margin:0;">Phone: '+farmAccessArr[i].user_phone+'</p> <p style="margin:0;">Email: '+farmAccessArr[i].user_email+'</p> </div> <div class="col-4"> <div class="form-group"> <button class="btn btn-warning btn-small toggleFarmer" user_id="'+farmAccessArr[i].user_id+'">Disallow User</button> </div> </div> </div> </div>');
                    }else{
                        $('#manageFarmerForm').append('<div class="form-group"> <div class="row"> <div class="col-8"> <h6>❌'+farmAccessArr[i].user_name+'</h6> <p style="margin:0;">Phone: '+farmAccessArr[i].user_phone+'</p> <p style="margin:0;">Email: '+farmAccessArr[i].user_email+'</p> </div> <div class="col-4"> <div class="form-group"> <button class="btn btn-primary toggleFarmer" user_id="'+farmAccessArr[i].user_id+'">Allow User</button> </div> </div> </div> </div>');
                    }
            }

            $('#manageFarmerModal').modal('show');

        })

        $(document).on('click','.toggleFarmer',function(){

            var farmer_id = $(this).attr('user_id');
            var operation;
            if($(this).hasClass('btn-warning')){
                operation = 'disallow';
            }else{
                operation = 'allow';
            }

            $('.toggleFarmer').attr('disabled','true');
            $('.toggleFarmer').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>')

            $.ajax({
                url:'assets/php/manageFarmer.php',
                data:{'user_id':farmer_id,'farm_id':window._dashboard.view_farm_id,'operation':operation},
                type: 'POST'
            }).done(function(data){
                window._dashboard.generateDashboard(function(){
                    window.location.reload();
                })
            })


        })

















    	//////decoration functions

    	var sidewidth = $('.sidebarWrapper').width();
    	var viewportWidth = $(window).width();

    	if(viewportWidth < 600){
            var dashboardWidth = Number(sidewidth) + Number(viewportWidth);

            console.log(sidewidth,viewportWidth,dashboardWidth);
            $('.dashboardBody').width(dashboardWidth);
            $('.cycleInitCover').remove();
    		toggleSide();

    	}else{
            $('.toggleSide').remove();
            var graphCardOffset = $($('.dashboardCard')[0]).offset();
            var cycleInitWidth = (Number($($('.dashboardCard')[0]).outerWidth()) + Number($($('.dashboardCard')[1]).outerWidth()) + 15) + 'px';

            $('.cycleInitCover').offset({top: 0, left: graphCardOffset.left});
            $('.cycleInitCover').css('width',cycleInitWidth);
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
                    $('.mainContentCover').css('zIndex','300');
        		}
            }
    	}



        


        $(document).on('click','.detailTrigger',function(){
            $('.dashboardWrapper').toggleClass('dashboardShrink');
            $('.dashboardNavigate').css('display','block');
            $('.dashboardNavigate').append('<p>Dashboard</p>');

            $('.detailBackground').css('z-index',100);
            $('.detailBackground').css('opacity','1');
            $('.detailWrapper').css('top','0');
            var level = $(this).attr('level');
            var detail_id = $(this).attr('detail_id');

            $('.detailBody').empty();
            $('.detailBody').html('<div style="width:100%;padding-top:3rem;display:flex;justify-content:center;"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>');

            switch(level){

                case 'batch':
                    if(viewportWidth<600){
                        var contentPage = 'detailBatchMobile.php';
                    }else{
                        var contentPage = 'detailBatch.php';
                    }
                    // $('[name="init_project_uid"]').val(detail_id);
                    break;

                case 'house':
                    var contentPage = 'detailHouse.php';
                    break;

                case 'stock':
                    var contentPage = 'detailStock.php';
                    break;


                case 'team':
                    var contentPage = 'detailTeam.php';
                    break;

            }

            $.post(contentPage,{'detail':detail_id},function(data){
                $('.detailBody').empty();
                $('.detailBody').html(data);
            })



        })

        $(document).on('click','.detailBackground',function(){
            $('.dashboardNavigate').empty();
            $('.dashboardNavigate').css('display','none');
            $('.dashboardWrapper').toggleClass('dashboardShrink');

            $('.detailBackground').css('z-index',-100);
            $('.detailBackground').css('opacity','0');
            $('.detailWrapper').css('top','200vh');            
        })

        if(viewportWidth > 600){
            $('.costTableDiv').height($('.costTableDiv').parent().height());
            $('#batchList').height($('#batchList').parent().height());
        }





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
                                                    batchTempTotalWeight = batchTempTotalWeight + ( (initBird - (Number(batchRecord[k].bird_death) + Number(batchRecord[k].bird_cull))) * Number(houseWeightBatch[obj][house]));
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

        $(document).ready(function() {

          $(window).keydown(function(event){

            if(event.keyCode == 13) {
              event.preventDefault();

                var target = $(event.target);
                var formDOM = $(target).parentsUntil('form').parent();
                var formId = $(formDOM).attr('id');

                validateForm(formId);

              return false;
            }
          });

          $('.farmRow[farm_id="overall"]').click();

        });

        function validateForm(form_id){

            var instance = $('#'+form_id).parsley({
                errorClass: 'is-invalid',
                successClass: 'is-valid',
                errorsWrapper: '',
                errorTemplate: '',
                trigger: 'change'
            });

            instance.validate();

            if(instance.isValid()){
                switch(form_id){

                    case 'stockAddForm':
                        var stockData = $('#stockAddForm').serialize();

                        $('#stockAddForm').find('input').attr('disabled','true');
                        $('#stockAddForm').find('textarea').attr('disabled','true');
                        $('#stockAddForm').find('select').attr('disabled','true');

                        $('#addStockConfirm').attr('disabled','true');
                        $('#addStockConfirm').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>')

                        $.ajax({
                            url: 'assets/php/stockAdd.php',
                            type: 'POST',
                            data: stockData,
                            success: function(data){
                                $('#addStockModal').modal('hide');
                                window._dashboard.generateDashboard();
                                $('.farmRow[farm_id="overall"]').click();
                            }
                        });
                        break;

                    case 'houseAddForm':
                        var houseData = $('#houseAddForm').serialize();

                        $('#houseAddForm').find('input').attr('disabled','true');
                        $('#houseAddForm').find('textarea').attr('disabled','true');
                        $('#houseAddForm').find('select').attr('disabled','true');

                        $('#addHouseConfirm').attr('disabled','true');
                        $('#addHouseConfirm').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>')

                        $.ajax({
                            url: 'assets/php/houseAdd.php',
                            type: 'POST',
                            data: houseData,
                            success: function(data){
                                $('#addHouseModal').modal('hide');
                                window._dashboard.generateDashboard();
                                $('.farmRow[farm_id="overall"]').click();
                            }
                        });
                        break;

                    case 'farmAddForm': 

                        var farmData = $('#farmAddForm').serialize();

                        $('#farmAddForm').find('input').attr('disabled','true');
                        $('#farmAddForm').find('textarea').attr('disabled','true');
                        $('#farmAddForm').find('select').attr('disabled','true');

                        $('#addFarmConfirm').attr('disabled','true');
                        $('#addFarmConfirm').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>')

                        $.ajax({
                            url: 'assets/php/farmAdd.php',
                            type: 'POST',
                            data: farmData,
                            success: function(data){
                                $('#addFarmModal').modal('hide');
                                window._dashboard.generateDashboard();
                            }
                        });                    
                        break;

                    case 'farmEditForm': 
                        var farmData = $('#farmEditForm').serialize();

                        $('#farmEditForm').find('input').attr('disabled','true');
                        $('#farmEditForm').find('textarea').attr('disabled','true');
                        $('#farmEditForm').find('select').attr('disabled','true');

                        $('#editFarmConfirm').attr('disabled','true');
                        $('#editFarmConfirm').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>')

                        $.ajax({
                            url: 'assets/php/farmEdit.php',
                            type: 'POST',
                            data: farmData,
                            success: function(data){
                                $('#editFarmModal').modal('hide');
                                window._dashboard.generateDashboard();
                                window._dashboard.updateLeftPaneDOM();
                            }
                        });
                        break;

                    case 'cycleAddForm': 
                        var cycleDate = $('#cycleAddForm').serialize();

                        $('#cycleAddForm').find('input').attr('disabled','true');
                        $('#cycleAddForm').find('textarea').attr('disabled','true');
                        $('#cycleAddForm').find('select').attr('disabled','true');

                        $('#cycleAddConfirm').attr('disabled','true');
                        $('#cycleAddConfirm').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>')

                        $.ajax({
                            url: 'assets/php/cycleAdd.php',
                            type: 'POST',
                            data: cycleDate,
                            success: function(data){
                                $('#cycleAddModal').modal('hide');
                                window._dashboard.generateDashboard();
                            }
                        });
                        break;

                    case 'batchAddForm': 
                        var houseInit = [];

                        for(var i=0;i<$('.house_bird_init_input').length;i++){

                            if($($('.house_bird_init_input')[i]).val() > 0){
                                var newHouseInitData = {
                                    house_id: $($('.house_bird_init_input')[i]).attr('house_id'),
                                    quantity: $($('.house_bird_init_input')[i]).val()
                                }

                                houseInit.push(newHouseInitData);
                            }

                        }

                        

                        var payload = {
                            houseInitQuantity: houseInit,
                            batch_name: $('input[name="batch_name"]').val(),
                            batch_type: $('select[name="batch_type"]').val(),
                            batch_uid : guid(),
                            batch_status: getCategoryCode('batch_status','initialized'),
                            batch_company : window._dashboard.company_id,
                            batch_cycle_id: window._dashboard.farm_list[window._dashboard.view_farm_id].active_cycle_id,
                            batch_price_per_bird: $('input[name="batch_price_per_bird"]').val(),
                            batch_cost_id: getCategoryCode('cost','day 0 chick')
                        }


                        $('#batchAddForm').find('input').attr('disabled','true');
                        $('#batchAddForm').find('textarea').attr('disabled','true');
                        $('#batchAddForm').find('select').attr('disabled','true');

                        $('#batchAddConfirm').attr('disabled','true');
                        $('#batchAddConfirm').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>')

                        $.ajax({
                            url: 'assets/php/batchAdd.php',
                            type: 'POST',
                            data: payload,
                            success: function(data){

                                console.log(data);

                                $('#batchAddModal').modal('hide');
                                window._dashboard.generateDashboard();
                                $('.farmRow[farm_id="overall"]').click();
                            }
                        });
                        break;

                    case 'stockAddFeedForm': 
                        var costCycleId = $('#stockAddFeedConfirm').attr('cycle_id');
                        var feedArr = [];
                        var priceObj = {};

                        for(var i=0;i<window.category.length;i++){
                            if(window.category[i].category_level == 'feed'){

                                var feed_id = window.category[i].category_id;

                                for(var j=0;j<window.category.length;j++){

                                    if(window.category[j].category_code == feed_id){
                                        priceObj[window.category[j].category_code] =  window.category[j].category_desc;
                                    }

                                }

                            }
                        }

                        var costNoteString = "";
                        var costAmount = 0;

                        for(var i=0;i<$('.stock_add_feed_input').length;i++){

                            if($($('.stock_add_feed_input')[i]).val() > 0){
                                var feedData = {
                                    sb_item: $($('.stock_add_feed_input')[i]).attr('feed_id'),
                                    quantity: $($('.stock_add_feed_input')[i]).val()
                                }



                                var newString = getCategoryDesc('feed',feedData.sb_item) + " " + feedData.quantity + " bag(s) " + "(" + feedData.quantity + " X RM" + priceObj[feedData.sb_item] + " = RM" + (Number(feedData.quantity) * Number(priceObj[feedData.sb_item])) +" ) \\n";
                                costNoteString = costNoteString + newString;

                                costAmount = costAmount + (Number(feedData.quantity) * Number(priceObj[feedData.sb_item]));

                                feedArr.push(feedData);
                            }

                        }



                        

                        var payload = {
                            feedData : feedArr,
                            sb_stock_id: $('input[name="stock_id"]').val(),
                            sr_record_type: getCategoryCode('record_type','restock'),
                            cost_category: getCategoryCode('cost','feed'),
                            cost_note: costNoteString,
                            cost_amount: costAmount,
                            cost_cycle_id: costCycleId

                        }

                        console.log(payload);

                        $('#stockAddFeedForm').find('input').attr('disabled','true');
                        $('#stockAddFeedForm').find('textarea').attr('disabled','true');
                        $('#stockAddFeedForm').find('select').attr('disabled','true');

                        $('#stockAddFeedConfirm').attr('disabled','true');
                        $('#stockAddFeedConfirm').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>')

                        $.ajax({
                            url: 'assets/php/stockAddFeed.php',
                            type: 'POST',
                            data: payload,
                            success: function(data){

                                window.location.reload();
                                console.log(data);

                                $('#stockAddFeedModal').modal('hide');
                                window._dashboard.generateDashboard();
                                $('.detailBackground').click();
                                // writeToFirebase();
                            }
                        });


                        break;

                    case 'addCostForm': 
                        var costData = $('#addCostForm').serialize();

                        $('#addCostForm').find('input').attr('disabled','true');
                        $('#addCostForm').find('textarea').attr('disabled','true');
                        $('#addCostForm').find('select').attr('disabled','true');

                        $('#addCostConfirm').attr('disabled','true');
                        $('#addCostConfirm').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>')

                        $.ajax({
                            url: 'assets/php/costAdd.php',
                            type: 'POST',
                            data: costData,
                            success: function(data){
                                console.log(data);
                                $('#addCostModal').modal('hide');
                                window._dashboard.generateDashboard();
                            }
                        });

                        break;


                    case 'showPriceForm':
                        var batchPriceData = [];

                        for(var i=0;i<$('.batchPriceInput').length;i++){

                            var batchPrice = $($('.batchPriceInput')[i]).val();

                            var batch_cat_id = $($('.batchPriceInput')[i]).attr('batch_cat_id');
                            var batchPriceExist = false;
                            var batchPriceId;

                            for(var j=0;j<window.category.length;j++){

                                if(window.category[j].category_level == 'batch_price' && window.category[j].category_code == batch_cat_id){

                                    batchPriceId = window.category[j].category_id;
                                    batchPriceExist = true;
                                }


                            }

                            if(batchPriceExist){

                                var batchPriceObj = {
                                    operation: 'edit',
                                    batch_price_id: batchPriceId,
                                    batch_price: batchPrice
                                }

                            }else{

                                var batchPriceObj = {
                                    operation: 'insert',
                                    batch_cat_id: batch_cat_id,
                                    batch_price: batchPrice
                                }


                            }

                            batchPriceData.push(batchPriceObj);
                        }

                        $('#showPriceForm').find('input').attr('disabled','true');
                        $('#showPriceForm').find('textarea').attr('disabled','true');
                        $('#showPriceForm').find('select').attr('disabled','true');

                        $('#showPriceConfirm').attr('disabled','true');
                        $('#showPriceConfirm').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>')

                        $.ajax({
                            url: 'assets/php/batchPrice.php',
                            type: 'POST',
                            data: {'batch_price':batchPriceData},
                            success: function(data){
                                window.location.reload();
                            }
                        }); 
                        break;

                    case 'addBatchRecordForm': 
                        $('#addBatchRecordConfirm').click();
                        break;

                    case 'addEventForm': 
                        var eventData = {
                            event_type: $('[name="event_type"]').val(),
                            event_date: $('[name="event_date"]').val(),
                            event_note: $('[name="event_note"]').val(),
                            event_batch_uid: window.view_batch.batch_uid
                        }

                        $('#addEventForm').find('input').attr('disabled','true');
                        $('#addEventForm').find('textarea').attr('disabled','true');
                        $('#addEventForm').find('select').attr('disabled','true');

                        $('#addEventConfirm').attr('disabled','true');
                        $('#addEventConfirm').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>')

                        $.ajax({
                            url: 'assets/php/eventAdd.php',
                            type: 'POST',
                            data: eventData,
                            success: function(data){
                                console.log(data);
                                //$('#addEventModal').modal('hide');
                                // $('.detailBackground').click();
                                // $('.detailTrigger[detail_id="'+window.view_batch.batch_uid+'"]');
                                //window._dashboard.generateDashboard();
                                window.location.reload();
                            }
                        });
                        break;

                    case 'feedPriceForm': 
                        var priceData = $('#feedPriceForm').serialize();

                        console.log(priceData);

                        $('#feedPriceForm').find('input').attr('disabled','true');
                        $('#feedPriceForm').find('textarea').attr('disabled','true');
                        $('#feedPriceForm').find('select').attr('disabled','true');

                        $('#feedPriceConfirm').attr('disabled','true');
                        $('#feedPriceConfirm').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>')

                        $.ajax({
                            url: 'assets/php/feedPrice.php',
                            type: 'POST',
                            data: priceData,
                            success: function(data){
                                // console.log(data);
                                // $('#feedPriceModal').modal('hide');
                                // window._dashboard.generateDashboard(function(){
                                //     $('.detailTrigger[level="stock"]').click();
                                // });
                                window.location.reload();
                            }
                        });
                        break;

                    case 'houseEditForm': 
                        var houseData = $('#houseEditForm').serialize();
                        var house_farm_id = $('#houseEditForm').find('input[name="house_farm_id"]').val();
                        window.previousElement = '.detailTrigger[detail_id="'+house_farm_id+'"]';

                        console.log('ele1',window.previousElement);

                        $('#houseEditForm').find('input').attr('disabled','true');
                        $('#houseEditForm').find('textarea').attr('disabled','true');
                        $('#houseEditForm').find('select').attr('disabled','true');

                        $('#houseEditConfirm').attr('disabled','true');
                        $('#houseEditConfirm').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>')

                        $.ajax({
                            url: 'assets/php/houseEdit.php',
                            type: 'POST',
                            data: houseData,
                            success: function(data){
                                // window._dashboard.generateDashboard(function(){
                                //     $('#houseEditModal').modal('hide');
                                //     $('.detailBackground').click();
                                //     console.log('ele2',window.previousElement);
                                //     $(window.previousElement).click();
                                //     window.previousElement = null;
                                // });
                                window.location.reload();
                            }
                        });
                        break;


                }


            }



        }







    </script>

    <div class="footer" style="background: white;display: flex;flex-direction: column;justify-content: center;align-items: center;margin-top:1rem;">
        <img src="assets/img/logo.png" style="max-width:60px"class="img-responsive">
        <p>Developed by team Zettabyte from Bachelor Of Computer Science ( Data Engineering ) 2U2I study mode</p>
    </div>

</body>
</html>