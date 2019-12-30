<?php

$farm_id = $_GET['farm_id'];
$farm_name = $_GET['farm_name'];
$access_level = $_GET['access_level'];

echo "<div class='row generatedRow'>";

echo "
<div class='col-11 d-flex justify-content-start'>";

if($access_level >= 3){
    echo "
    <div class='newButtonColumn'>
            <div class='dropdown'>
              <button class='btn btn-secondary d-flex justify-content-center align-items-center' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' style='border-radius: 3rem;width:100%;height:100%;'><i class='fas fa-plus'></i></button>
              <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                <a class='dropdown-item' href='#' id='addHouseButton'>House</a>
                <a class='dropdown-item' href='#' id='addStockButton'>Stock</a>
                <a class='dropdown-item' href='#' id='addBatchButton'>Batch</a>
                <a class='dropdown-item' href='#' id='addCostButton'>Cost</a>
                <a class='dropdown-item' href='#' id='editFarmButton' farm_id='".$farm_id."'>Edit Farm</a>
              </div>                    
            </div>                        
    </div>";
}


echo "
    
    <div class='farmRow' farm_id='".$farm_id."'>
        <p style='margin: 0;font-family: Cabin, sans-serif;font-weight: 900;'>".$farm_name."</p>
    </div>
</div>
";
echo "</div>";



?>