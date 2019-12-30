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

    if(!isset($_SESSION['accessLevel'])){
        $_SESSION['accessLevel'] = $row['access_level'];
    }

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

    <script src="assets/js/dashboardObject.js"></script>


</head>
<body>

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
                            <div class="col-3 d-xl-flex flex-column justify-content-xl-center"><i class="fas fa-user-friends d-lg-flex justify-content-lg-center panelIcon teamIcon detailTrigger" level="team" style="font-size: 20px;"></i>
                                <p class="text-center d-lg-flex justify-content-lg-center" style="font-size: 1rem;width: 100%;font-family: Cabin, sans-serif;font-weight: bold;"></p>
                            </div>
                            <div class="col-3 d-xl-flex flex-column justify-content-xl-center" style="font-size: 20px;"><i class="fas fa-file-alt d-lg-flex justify-content-lg-center" style="font-size: 20px;"></i>
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
    							<h1 id="cycleNameDisplay">Cycle #</h1>
    						</div>
                            <div class="col-5">
                                <div class="row d-flex justify-content-start">
                                    <div class="col-2">                                        
                                        <button class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Stop Cycle"><i class="fas fa-stop"></i></button>
                                    </div>
                                    <div class="col-2">
                                        <button class="btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Generate Report"><i class="fas fa-pen"></i></button>
                                    </div>
                                </div>
                                
                            </div>
    						<div class="col-2">
    							<button class="btn btn-primary toggleSide">Toggle</button>
    						</div>
    					</div>

    					
    					
    				</div>
                    <div class="row dashboardRow">
                        <div class="col-md-6 col-sm-12 dashboardCol">   <!-- livability stats -->
                            <div class="shadow dashboardCard"></div>
                        </div>
                        <div class="col-md-3 col-sm-12 dashboardCol">   <!-- batch directory -->
                            <div class="shadow dashboardCard">
                                <div id="batchList"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 dashboardCol">   <!-- house -->
                            <div class="shadow dashboardCard">
                                <div class="houseList"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row dashboardRow">
                        <div class="col-md-3 col-sm-12 dashboardCol">   <!-- profit & loss -->
                            <div class="shadow dashboardCard">
                                <div class="row">
                                    <div class="col">
                                        <p>Total Cost</p>
                                        <h3 id="totalCostDisplay"></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 dashboardCol">   <!-- cost table -->
                            <div class="shadow dashboardCard">
                                <div class="costTableDiv"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 dashboardCol">   <!-- feed stock -->
                            <div class="shadow dashboardCard">
                                <div id="stockList"></div>
                                <div class="row">
                                    <div class="col d-flex justify-content-center align-items-center">
                                        <button class="btn btn-primary detailTrigger" style="position: center;" level="stock">Details</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    				
    				
    			</div>
                <div class="mainContentCover toggleSide"></div>
                <div class="cycleInitCover">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">No Active Cycle</h5>
                            <p class="card-text">Definition of cycle. Lorem Ipsum dolor sit amet.</p>
                            <a href="#" class="btn btn-primary" id="cycleAddButton">Start</a>
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
                    <p>Some Important Instructions.</p>
                    <form method="POST" action="" id="farmAddForm">
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Farm Name" name="farm_name">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" placeholder="Address" name="farm_address"></textarea>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="farm_cat">
                                <?php                   ///Fetch all category for farm
                                    $sql = "SELECT category_code,category_desc,category_id
                                            FROM tb_category
                                            WHERE category_level = 'farm'";

                                    $result = mysqli_query($con,$sql);

                                    while($row = mysqli_fetch_assoc($result)){
                                        echo "
                                            <option value='".$row['category_id']."' >".$row['category_desc']."</option>
                                        ";
                                    }
                                ?>
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
                            <input class="form-control" type="text" placeholder="Farm Name" name="edit_farm_name">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" placeholder="Address" name="edit_farm_address"></textarea>
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
                            <input class="form-control" type="text" placeholder="Cycle Name" name="cycle_name">
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
                    <p>Some Important Instructions.</p>
                    <form method="POST" action="assets/php/batchAdd.php" id="batchAddForm">
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Batch Name" name="batch_name">
                        </div> 
                        <div class="form-group">
                            <label>Price Per Bird</label>
                            <div class="row">
                                <div class="col-3 d-flex justify-content-right align-items-center">
                                    <p class="text-right" style="margin: 0;">RM</p>
                                </div>
                                <div class="col-9">
                                    <input class="form-control" type="number" placeholder="" name="batch_price_per_bird">
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
                            <input class="form-control" type="text" placeholder="House Name" name="house_name">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="House Capacity" name="house_capacity">
                        </div>
                        
                        <div class="form-group">
                            <select class="form-control" name="house_cat">
                                <?php                   ///Fetch all category for farm
                                    $sql = "SELECT category_code,category_desc,category_id
                                            FROM tb_category
                                            WHERE category_level = 'house'";

                                    $result = mysqli_query($con,$sql);

                                    while($row = mysqli_fetch_assoc($result)){
                                        echo "
                                            <option value='".$row['category_id']."' >".$row['category_desc']."</option>
                                        ";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="house_status">
                                <?php                   ///Fetch all category for farm
                                    $sql = "SELECT category_code,category_desc,category_id
                                            FROM tb_category
                                            WHERE category_level = 'house_status'";

                                    $result = mysqli_query($con,$sql);

                                    while($row = mysqli_fetch_assoc($result)){
                                        echo "
                                            <option value='".$row['category_id']."' >".$row['category_desc']."</option>
                                        ";
                                    }
                                ?>
                            </select>
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
                            <input class="form-control" type="text" placeholder="Store Name" name="stock_name">
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
                            <input class="form-control" type="date" name="cost_date">
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
                                    <input class="form-control" type="" name="cost_amount" id="cost_amount">
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


    <script type="text/javascript">



    	if(window._dashboard == null){
            window._dashboard = new dashboard('<?php echo $company_id ?>','<?php echo $access_level ?>');
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
                        $('#batchList').html(window._dashboard.farm_list[window._dashboard.view_farm_id]['cycle_list'][j].batch_dom);
                    }
                }

                var totalCost = 0;

                $('.costTableDiv').empty();
                $('.costTableDiv').append('<table class="table"> <thead> <tr> <th scope="col">Date</th> <th scope="col">Category</th> <th scope="col">Remarks</th> <th scope="col">RM</th> </tr> </thead> <tbody id="costTableBody"> </tbody> </table>');

                for(var i=0;i<window._dashboard.farm_list[window._dashboard.view_farm_id]['cycle_list'].length;i++){

                    if(window._dashboard.farm_list[window._dashboard.view_farm_id].cycle_list[i].cycle_id == window._dashboard.farm_list[window._dashboard.view_farm_id].active_cycle_id){

                        var cycleCostArr = window._dashboard.farm_list[window._dashboard.view_farm_id].cycle_list[i].cycle_cost;

                        for(var j=0;j<cycleCostArr.length;j++){

                            $('#costTableBody').append('<tr> <td>'+cycleCostArr[j].cost_date+'</td> <td>'+getCategoryDesc('cost',cycleCostArr[j].cost_category)+'</td> <td>'+cycleCostArr[j].cost_note+'</td> <td>'+cycleCostArr[j].cost_amount+'</td> </tr>');

                            totalCost = totalCost + Number(cycleCostArr[j].cost_amount);

                        }
                    }

                }

                $('#totalCostDisplay').text('RM '+totalCost);



            }else{
                $('.houseList').html(window._dashboard.overall('house'));
                $('#stockList').html(window._dashboard.overall('stock'));
                window._dashboard.overall('cycle');
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



        })



        $(document).on('click','#cycleAddButton',function(){

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
        })

        $(document).on('click','#addBatchButton',function(){

            $('select[name="batch_type"]').empty();      /// attach farm list

            console.log(window.category);

            for(var i=0;i<window.category.length;i++){

                if(window.category[i].category_level == 'batch'){
                    var batch_desc = window.category[i].category_desc;
                    var batch_id = window.category[i].category_id;
                    $('select[name="batch_type"]').append('<option value="'+batch_id+'">'+batch_desc+'</option>');
                }
            }

            $('#initBatchHouseDiv').empty();

            for(var i=0;i<window._dashboard.farm_list[window._dashboard.view_farm_id].house_list.length;i++){

                var house_id = window._dashboard.farm_list[window._dashboard.view_farm_id].house_list[i].house_id;

                var house_name = window._dashboard.farm_list[window._dashboard.view_farm_id].house_list[i].house_name;

                $('#initBatchHouseDiv').append('<div class="form-group"><div class="row"><div class="col-6 d-flex justify-content-center align-items-center"><h6>'+house_name+'</h6></div><div class="col-6 text-center"><p style="font-size:0.8rem;font-weight:900;font-family:Cabin;margin:0;">BIRD QUANTITY</p><div class="form-group"><input type="number" name="" house_id="'+house_id+'" class="house_bird_init_input form-control" value="0"></div></div></div></div>');


            }

            


            $('#batchAddModal').modal('show');
            $('#batchAddForm').find('input').removeAttr('disabled');
            $('#batchAddForm').find('textarea').removeAttr('disabled');
            $('#batchAddForm').find('select').removeAttr('disabled');
            $('#batchAddConfirm').removeAttr('disabled');
            $('#batchAddConfirm').html('Start');

        });

       $('#batchAddConfirm').on('click',function(){

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
        })




		$(document).on('click','.stockAddFeedButton',function(){

			$('#addFeedDiv').empty();      /// attach farm list
            var costCycleId = $(this).attr('cycle_id');
            $('#stockAddFeedConfirm').attr('cycle_id',costCycleId);

            for(var i=0;i<window.category.length;i++){

                if(window.category[i].category_level == 'feed'){
                    var feed_desc = window.category[i].category_desc;
                    var feed_id = window.category[i].category_id;

                    for(var j=0;j<window.category.length;j++){

                        if(window.category[j].category_code == feed_id && window.category[j].category_level == 'feed_price'){

                            var feed_price = window.category[j].category_desc;

                            $('#addFeedDiv').append('<div class="form-group"><div class="row"><div class="col-6 d-flex justify-content-center align-items-center flex-column"><h6>'+feed_desc+'</h6><p>RM '+feed_price+' per bag</p></div><div class="col-6 text-center"><p style="font-size:0.8rem;font-weight:900;font-family:Cabin;margin:0;">BAGS</p><div class="form-group"><input type="number" feed_id="'+feed_id+'" class="stock_add_feed_input form-control" value="0"></div></div></div></div>');


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

            for(var i=0;i<priceArr.length;i++){

                var currentValue = Number($('.stock_add_feed_input[feed_id="'+priceArr[i].feed_id+'"]').val());
                totalPrice = totalPrice + (currentValue * priceArr[i].price);
            }

            $('#feedPriceTotal').text('Total: RM ' +totalPrice);



        });


		$(document).on('click','#stockAddFeedConfirm',function(){
			
            var costCycleId = $(this).attr('cycle_id');
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

                    console.log(data);

                    $('#stockAddFeedModal').modal('hide');
                    window._dashboard.generateDashboard();
                    $('.farmRow[farm_id="overall"]').click();
                    $('.detailBackground').click();
                    writeToFirebase();
                }
            });

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



        })



















    	//////decoration functions

    	var sidewidth = $('.sidebarWrapper').width();
    	var viewportWidth = $(window).width();

    	if(viewportWidth < 600){
            var dashboardWidth = Number(sidewidth) + Number(viewportWidth);

            console.log(sidewidth,viewportWidth,dashboardWidth);
            $('.dashboardBody').width(dashboardWidth);
    		toggleSide();
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



        var graphCardOffset = $($('.dashboardCard')[0]).offset();
        var cycleInitWidth = (Number($($('.dashboardCard')[0]).outerWidth()) + Number($($('.dashboardCard')[1]).outerWidth()) + 15) + 'px';

        $('.cycleInitCover').offset({top: 0, left: graphCardOffset.left});
        $('.cycleInitCover').css('width',cycleInitWidth);


        $(document).on('click','.detailTrigger',function(){
            $('.dashboardWrapper').toggleClass('dashboardShrink');
            $('.dashboardNavigate').append('<p>Dashboard</p>')

            $('.detailBackground').css('z-index',100);
            $('.detailBackground').css('opacity','1');
            $('.detailWrapper').css('top','0');
            var level = $(this).attr('level');
            var detail_id = $(this).attr('detail_id');

            $('.detailBody').empty();
            $('.detailBody').html('<div style="width:100%;padding-top:3rem;display:flex;justify-content:center;"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>');

            switch(level){

                case 'batch':
                    var contentPage = 'detailBatch.php';
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
            $('.dashboardWrapper').toggleClass('dashboardShrink');

            $('.detailBackground').css('z-index',-100);
            $('.detailBackground').css('opacity','0');
            $('.detailWrapper').css('top','200vh');            
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




    </script>


</body>
</html>