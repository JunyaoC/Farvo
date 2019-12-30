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

    mysqli_close($con);

?>

<!DOCTYPE html>
<html>

<head>
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
    <link rel="stylesheet" href="assets/css/styles2.css">
    <script src="assets/js/dashboardObject.js"></script>
</head>

<body>
    <div class="dashboardBody">
        <div class="dashboardNavigate"></div>
        <div style="display: flex;flex-direction: row;justify-content: flex-start;height: 100%;">
            <div style="width: 15%;padding: 1rem 0;" id="farmLeftPanel">
                <div style="min-height: 22vh;padding: 0 15px 0 0;">
                    <h1 class="text-center d-xl-flex justify-content-xl-start align-items-xl-end" style="font-family: Cabin, sans-serif;font-weight: bold;font-size: 1rem;color: rgb(71,74,77);">FARVO</h1>
                    <h1 class="text-center" style="font-family: Cabin, sans-serif;font-weight: bold;font-size: 1.5rem;color: rgb(71,74,77);padding: 10px;"><?php echo $row['company_name']; ?></h1>
                    <div class="row" style="margin: 0;padding: 1rem 0;">
                        <div class="col-3 col-xl-3 d-xl-flex flex-column justify-content-xl-center"><i class="far fa-building d-lg-flex justify-content-lg-center companyIcon panelIcon" style="font-size: 20px;"></i>
                            <p class="d-lg-flex justify-content-lg-center align-items-lg-center" style="font-size: 1rem;width: 100%;font-family: Cabin, sans-serif;font-weight: bold;"></p>
                        </div>
                        <div class="col-3 d-xl-flex flex-column justify-content-xl-center"><i class="fas fa-user-friends d-lg-flex justify-content-lg-center panelIcon teamIcon detailTrigger" level="team" style="font-size: 20px;"></i>
                            <p class="text-center d-lg-flex justify-content-lg-center" style="font-size: 1rem;width: 100%;font-family: Cabin, sans-serif;font-weight: bold;"></p>
                        </div>
                        <div class="col-3 d-xl-flex flex-column justify-content-xl-center" style="font-size: 20px;"><i class="fas fa-bell d-lg-flex justify-content-lg-center" style="font-size: 20px;"></i>
                            <p class="text-center d-lg-flex justify-content-lg-center" style="font-size: 1rem;width: 100%;font-family: Cabin, sans-serif;font-weight: bold;"></p>
                        </div>
                        <div class="col-3 d-xl-flex flex-column justify-content-xl-center"><i class="fas fa-door-open d-lg-flex justify-content-lg-center panelIcon signoutIcon" style="font-size: 20px;"></i>
                            <p class="text-center d-lg-flex justify-content-lg-center" style="font-size: 1rem;width: 100%;font-family: Cabin, sans-serif;font-weight: bold;"></p>
                        </div>
                    </div>                
                </div>
                <div class="row">
                    <div class="col-9">
                        <div class="shadow farmRowHead" style="background-color: rgb(63,39,213);color: white;">
                            <div class="row" style="width: 100%;margin: 0;">
                                <div class="col-8 d-xl-flex align-items-xl-center">
                                    <p class="text-left" style="margin: 0 0 0 -1rem;font-family: Cabin, sans-serif;font-weight: 900;font-size: 27px;">Farms</p>
                                </div>
                                <?php
                                    if($_SESSION['accessLevel'] == 4){
                                        echo '<div class="col-3 col-xl-4 d-xl-flex justify-content-xl-end align-items-xl-center"><i class="fas fa-plus d-xl-flex justify-content-xl-center align-items-xl-center" id="addFarmButton" style="font-size: 22px;color: rgb(52,52,52);"></i></div>';
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
            <div style="width: 85%;display: flex;flex-direction: column;">
                <div class="row dashboardRow" style="width: 100%;margin: 0;" row_position="top">
                    <div class="col-7 dashboardCard" style="padding: 0 15px 0 15px;margin:0;" card_name="overview">
                        <div class="border rounded shadow-sm" style="background-color: #ffffff;padding: 0.5rem;height: 100%;">
                            <div class="text-center titleRow">
                                <h6 class="text-center" style="color: rgb(115,115,115);font-family: Cabin, sans-serif;font-weight: bold;">Overview</h6>
                            </div>
                            <div class="dashboardContent">
                                <div class="farmCanvasDiv" style="height: 100%;">
                                    <canvas id="farmCanvas"></canvas>
                                </div>                 
                            </div>
                        </div>
                    </div>
                    <div class="col-2 dashboardCard" style="padding: 0;" card_name="numbers">
                        <div style="display: flex;flex-direction: column;height: 100%;justify-content: space-between;">
                            <div class="border rounded shadow-sm" style="background-color: #ffffff;padding: 0.5rem;height: 30%;">
                                <div class="text-center titleRow">
                                    <h6 class="text-center" style="color: rgb(115,115,115);font-family: Cabin, sans-serif;font-weight: bold;">Death</h6>
                                </div>
                                <div class="dashboardContent">
                                    <h2 class="text-center totalDeathDiv"></h2>
                                    <div class="d-flex justify-content-center bufferDiv" style="padding-top: 3rem;"></div>
                                </div>
                            </div>
                            <div class="border rounded shadow-sm" style="background-color: #ffffff;padding: 0.5rem;height: 30%;">
                                <div class="text-center titleRow">
                                    <h6 class="text-center" style="color: rgb(115,115,115);font-family: Cabin, sans-serif;font-weight: bold;">Culls</h6>
                                </div>
                                <div class="dashboardContent">
                                    <h2 class="text-center totalCullDiv"></h2>
                                    <div class="d-flex justify-content-center bufferDiv" style="padding-top: 3rem;"></div>
                                </div>
                            </div>
                            <div class="border rounded shadow-sm" style="background-color: #ffffff;padding: 0.5rem;height: 30%;">
                                <div class="text-center titleRow">
                                    <h6 class="text-center" style="color: rgb(115,115,115);font-family: Cabin, sans-serif;font-weight: bold;">Catch</h6>
                                </div>
                                <div class="dashboardContent">
                                    <h2 class="text-center totalCatchDiv"></h2>
                                    <div class="d-flex justify-content-center bufferDiv" style="padding-top: 3rem;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 dashboardCard" card_name="project">
                        <div class="row" style="height: 100%;">
                            <div class="col-12" style="padding: 0 0 0 15px;">
                                <div class="border rounded shadow-sm" style="background-color: #ffffff;padding: 0.5rem;height: 100%;">
                                    <div class="text-center titleRow">
                                        <h6 class="text-center" style="color: rgb(115,115,115);font-family: Cabin, sans-serif;font-weight: bold;">Projects</h6>
                                    </div>
                                    <div class="dashboardContent">
                                        <div class="table-responsive">
                                            <table class="table table-hover text-center">
                                                <thead>
                                                    <tr>
                                                        <th>Project</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="projectTableBody">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row dashboardRow" style="width: 100%;margin: 0;padding-top: 0.5rem" row_position="bottom">
                    <div class="col dashboardCard" card_name="notification" style="padding: 0;">
                        <div class="row" style="height: 100%;margin: 0;">
                            <div class="col-12" style="padding: 0  15px 0 15px;">
                                <div class="border rounded shadow-sm" style="background-color: #ffffff;padding: 0.5rem;height: 100%;">
                                    <div class="text-center titleRow">
                                        <h6 class="text-center" style="color: rgb(115,115,115);font-family: Cabin, sans-serif;font-weight: bold;">Overview</h6>
                                    </div>
                                    <div class="dashboardContent">
                                        <h3>Notification</h3>
                                    </div>
                                    <div class="d-flex justify-content-center bufferDiv" style="padding-top: 3rem;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col dashboardCard" style="padding: 0;margin:0;" card_name="store">
                        <div class="row" style="height: 100%;margin: 0;">
                            <div class="col-12" style="padding: 0;margin:0;">
                                <div class="border rounded shadow-sm" style="background-color: #ffffff;padding: 0.5rem;height: 100%;">
                                    <div class="text-center titleRow">
                                        <h6 class="text-center" style="color: rgb(115,115,115);font-family: Cabin, sans-serif;font-weight: bold;">Store</h6>
                                    </div>
                                    <div class="dashboardContent" style="width: 100%;height: 100%;">
                                        <div class="row" style="height: 100%;">
                                            <div class="col-6">
                                                <div style="height: 50%;width: 100%;" id="storeChartDiv">
                                                    <canvas id="storeChart"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Store</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="stockList">
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="d-flex justify-content-center bufferDiv" style="padding-top: 3rem;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 dashboardCard" style="padding: 0;" card_name="notification">
                        <div class="row" style="height: 100%;margin: 0;">
                            <div class="col-12" style="padding: 0 0 0 15px;">
                                <div class="border rounded shadow-sm" style="background-color: #ffffff;padding: 0.5rem;height: 100%;">
                                    <div class="text-center titleRow">
                                        <h6 class="text-center" style="color: rgb(115,115,115);font-family: Cabin, sans-serif;font-weight: bold;">Coop</h6>
                                    </div>
                                    <div class="dashboardContent" style="padding: 1rem;">
                                        <div class="houseList"></div>
                                    </div>
                                    <div class="d-flex justify-content-center bufferDiv" style="padding-top: 3rem;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                            <select class="form-control" name="edit_farm_cat">
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
                        <input type="hidden" name="edit_farm_company_id" value="<?php echo $found_company_id; ?>">
                        <input type="hidden" name="edit_farm_id">
                        <input type="hidden" name="new_dest" value="../companyDashboard.php?company=<?php echo $found_company_id; ?>">
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="editFarmConfirm">Edit</button></div>
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

    <div class="modal fade" role="dialog" tabindex="-1" id="editCoopModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Coop</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <p>Some Important Instructions.</p>
                    <form method="POST" action="php/coopEdit.php" id="coopEditForm">
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Coop Name" name="edit_house_name">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Coop Capacity" name="edit_house_capacity">
                        </div>
                        
                        <div class="form-group">
                            <select class="form-control" name="edit_house_cat">
                                <?php                   ///Fetch all category for farm
                                    $sql = "SELECT category_code,category_desc,category_id
                                            FROM tb_category
                                            WHERE category_level = 'coop'";

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
                            <select class="form-control" name="edit_house_status">
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
                        <input type="hidden" name="edit_coop_id">
                        <input type="hidden" name="edit_coop_company_id" value="<?php echo $found_company_id ?>">
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="coopEditConfirm">Add</button></div>
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

    <div class="modal fade" role="dialog" tabindex="-1" id="newProjectModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Project</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <p>Some Important Instructions.</p>

                    <div class="row">
                        <div class="col-6">
                            <div id="project_coop_picker" class="projectCoopRow"></div>
                        </div>
                        <div class="col-6">
                            <form method="POST" action="php/projectAdd.php">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Project Name" name="project_name">
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="project_type">
                                        <?php                   ///Fetch all category for farm
                                            $sql = "SELECT category_code,category_desc,category_id
                                                    FROM tb_category
                                                    WHERE category_level = 'project'";

                                            $result = mysqli_query($con,$sql);

                                            while($row = mysqli_fetch_assoc($result)){
                                                echo "
                                                    <option value='".$row['category_id']."' >".$row['category_desc']."</option>
                                                ";
                                            }
                                        ?>
                                    </select>
                                </div>

                                <input type="hidden" name="project_farm_id" value="">
                                <input type="hidden" name="project_uid" value="">
                                <input type="hidden" name="project_company" value="<?php echo $found_company_id ?>">
                            </form>
                            
                            <div id="coopSelectInfo">
                                <h5>Selected Coop:</h5>
                                <ul id="selectedCoopList"></ul>
                                <br>
                                <h5>Total Capacity: </h5>
                                <div id="selectedCoopCapacity"></div>
                            </div>
                            
                        </div>

                    </div>


                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="newProjectConfirm">Add</button></div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" role="dialog" tabindex="-1" id="initProjectModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Start Project</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <p>Some Important Instructions.</p>
                    <form method="POST" action="php/projectInit.php" id="initProject">
                        <input type="hidden" name="init_project_uid" value="">
                    </form>
                    <div>
                        <h4 class="initBirdTotal">Total: 0</h4>
                    </div>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="initProjectConfirm">Add</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="addProjectRecord">
        <input type="hidden" class="record_date_input">
        <input type="hidden" class="record_operation">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Record</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <p class="addProjectRecordDisplayDate" >Date: <?php echo date("l, j F Y"); ?></p>
                    <form method="POST" action="php/projectRecord.php">
                        <div class="row" id="projectRecord"></div>

                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="addProjectRecordConfirm">Add</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="storeAddStockModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Stock</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <form method="POST" action="php/storeAddStock.php" id="storeAddStockForm">
                        <div class="row">
                            <div class="col-8">
                                <select class="form-control" name="stock_item">
                                    <?php

                                        $sqlStock = "SELECT * FROM tb_category WHERE category_level = 'feed'";
                                        $resultStock = mysqli_query($con,$sqlStock);

                                        while ($rowStock = mysqli_fetch_assoc($resultStock)) {
                                            echo "<option value='".$rowStock['category_id']."'>".$rowStock['category_desc']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="stock_quantity">
                                </div>
                            </div>
                        </div>
                        <a href="#" id="newfeed">Add new feed</a>
                        <input type="hidden" name="record_date" value="<?php echo date('Y-n-d') ?>">
                        <input type="hidden" name="company_id" value="<?php echo $found_company_id ?>">
                        <input type="hidden" name="store_id" value="">
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="storeAddStockConfirm">Add</button></div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" tabindex="-1" id="storeNewFeedModal">
        <input type="hidden" class="store_id">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Stock</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <form method="POST" action="php/storeNewFeed.php" id="storeNewFeedForm">
                        <p>Feed Name</p>
                        <div class="form-group">
                            <input class="form-control" type="text" name="feed_name">
                        </div>
                        <input type="hidden" name="company_id" value="<?php echo $found_company_id ?>">
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="storeNewFeedConfirm">Add</button></div>
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
                        <option value="3">Admin</option>
                        <option value="2">Staff</option>
                        <option value="1">Farmer</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary confirmEditAccess" data-dismiss="modal">Edit</button>
                </div>
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
                            <?php

                                $sqlStock = "SELECT * FROM tb_category WHERE category_level = 'event'";
                                $resultStock = mysqli_query($con,$sqlStock);

                                while ($rowStock = mysqli_fetch_assoc($resultStock)) {
                                    echo "<option value='".$rowStock['category_id']."'>".$rowStock['category_desc']."</option>";
                                }
                            ?>
                        </select>
                        <input type="hidden" name="event_date" value="">
                        <input type="hidden" name="project_uid" value="">
                        <input type="hidden" name="company_id" value="<?php echo $found_company_id ?>">
                    </form>
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="addEventConfirm">Add</button></div>
            </div>
        </div>
    </div>


    <div class="detailBackground"></div>
    <div class="detailWrapper">
        <div class="detailContent">
            <div class="detailBody"></div>
        </div>
    </div>



    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-colorschemes"></script>
    <script type="text/javascript">
       

        if(window._dashboard == null){
            window._dashboard = new dashboard('<?php echo $company_id ?>','<?php echo $access_level ?>');
        }

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
            }else{
                $('.houseList').html(window._dashboard.overall('house'));
                $('#stockList').html(window._dashboard.overall('stock'));
            }




            $('.bufferDiv').empty();
            $('.dashboardContent').css('display','');

        });

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
            if($('[name="house_farm_id"]').val() != 'overall'){

                var farm_id = $(this).attr('farm_id');

                $.post('php/farmEditGet.php',{'farm_id': farm_id},function(data){

                    var responseFarm = JSON.parse(data);

                    console.log(responseFarm);

                    $('[name="edit_farm_name"]').val(responseFarm.farm_name);
                    $('[name="edit_farm_address"]').val(responseFarm.farm_address);
                    $('[name="edit_farm_cat"]').val(responseFarm.farm_cat);
                    $('[name="edit_farm_id"]').val(responseFarm.farm_id);
                })

                $('#editFarmModal').modal('show');
            } else{
                alert('Please select a farm.');
            }
        })

        $('#editFarmConfirm').on('click',function(){
            $('#farmEditForm').submit();
        })

       ////House

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

        ////Store

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

        ////Project

        $(document).on('click','#newProjectButton',function(){
            if($('[name="project_farm_id"]').val() != 'overall'){
                $('#newProjectModal').modal('show');
            } else{
                alert('Please select a farm.');
            }
        })

        $(document).on('click','.projectCoopDiv',function(){

            if($(this).attr('vacant_capacity') == 0){
                alert('This Coop is full!');
            } else{
                $(this).toggleClass('projectCoopDivSelected');

                var totalSelectedCapacity = 0;
                $('#selectedCoopList').empty();


                for(var i=0;i<$('.projectCoopDivSelected').length;i++){
                    totalSelectedCapacity = totalSelectedCapacity + Number($($('.projectCoopDivSelected')[i]).attr('vacant_capacity'));

                    $('#selectedCoopList').append('<li>' + $($('.projectCoopDivSelected')[i]).find('h6').text() + '</li>')

                }

                $('#selectedCoopCapacity').text('Total Capacity: ' + totalSelectedCapacity);
            }

        })

        $('#newProjectConfirm').on('click',function(){             

            var project_uid = guid();
            var project_name  = $('[name="project_name"]').val();
            var project_type  = $('[name="project_type"]').val();
            var project_company  = $('[name="project_company"]').val();

            var project_coop = $('.projectCoopDivSelected');
            var project_coop_obj ={};

            for(var i=0;i<project_coop.length;i++){
                project_coop_obj[i] = $($('.projectCoopDivSelected')[i]).attr('coop_id');
            }
            
            var projectPayload = {

                project_uid  : project_uid,
                project_name : project_name,
                project_type : project_type,
                project_company: project_company,
                coop : project_coop_obj
            }

            console.log(projectPayload);

            document.write('Creating Project...');

            $.post('php/projectAdd.php',projectPayload,function(){

            }).done(function(data){
                console.log(data);
                location.reload();
            })

        })


        ////Details

        $(document).on('click','.detailTrigger',function(){
            $('.dashboardBody').toggleClass('dashboardShrink');
            $('.dashboardNavigate').append('<p>Dashboard</p>')

            $('.detailBackground').css('z-index',100);
            $('.detailBackground').css('opacity','1');
            $('.detailWrapper').css('top','0');
            var level = $(this).attr('level');
            var detail_id = $(this).attr('detail_id');

            $('.detailBody').empty();
            $('.detailBody').html('<div style="width:100%;padding-top:3rem;display:flex;justify-content:center;"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>');

            switch(level){

                case 'project':
                    var contentPage = 'projectDashboard.php';
                    $('[name="init_project_uid"]').val(detail_id);
                    break;

                case 'coop':
                    var contentPage = 'detailCoop.php';
                    break;

                case 'store':
                    var contentPage = 'detailStore.php';
                    break;


                case 'team':
                    var contentPage = 'detailTeam.php';
                    detail_id = '<?php echo $found_company_id ?>';
                    break;

            }

            $.post(contentPage,{'detail':detail_id},function(data){
                $('.detailBody').empty();
                $('.detailBody').html(data);
            })



        })

        $(document).on('click','.detailBackground',function(){
            $('.dashboardNavigate').empty();
            $('.dashboardBody').toggleClass('dashboardShrink');

            $('.detailBackground').css('z-index',-100);
            $('.detailBackground').css('opacity','0');
            $('.detailWrapper').css('top','200vh');            
        })

        $('.companyIcon').on('click',function(){
            window.location.href = 'company.php';
        });

        $('.signoutIcon').on('click',function(){
            window.location.href = 'php/userLogoutProc.php';
        })

        function guid() {
          function s4() {
            return Math.floor((1 + Math.random()) * 0x10000)
              .toString(16)
              .substring(1);
          }
          return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
            s4() + '-' + s4() + s4() + s4();
        }
    </script>



</body>

</html>