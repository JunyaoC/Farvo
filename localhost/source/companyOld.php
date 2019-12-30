<?php

session_start();


    include('assets/php/dbconnect.php');

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    } else{
        header('Location: index.php');
    }

?>


<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>FARVO</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand" />
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cabin">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/material-icons.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
</head>

<body>
    <div class="contentWrapper">

        <div class="companyWrapper">
            <?php

                $sqlLvl = "SELECT access_level
                            FROM tb_access
                            WHERE access_company_id = '0' AND access_user_id = '$user_id'";

                $resultLvl = mysqli_query($con,$sqlLvl);
                $row = mysqli_fetch_assoc($resultLvl);
                $access_level = $row['access_level'];

                if($access_level == 5){

                    $sql = "SELECT *
                            FROM tb_company
                            JOIN tb_category ON tb_category.category_id = tb_company.company_cat";
                    $result = mysqli_query($con,$sql) or die(mysqli_error($con));
                    while($row = mysqli_fetch_assoc($result)){

                        if($row['company_id'] != 0 ){

                            if($row['category_desc'] == 'Deactivated'){
                                echo "
                                <div class='shadow companyDiv' company_id='".$row['company_id']."' style='display:none;'>
                                    <div class='row'>
                                        <div class='col'>
                                            <h1 class='text-left companyDivTitle'>".$row['company_name']."</h1>
                                        </div>
                                        <div class='col-2 d-flex justify-content-end'>
                                            <div class='d-lg-flex'><i class='material-icons' parent_company='".$row['company_id']."'>edit</i></div>
                                        </div>
                                    </div>                    
                                    <p class = 'company_cat' catId='".$row['category_id']."'>Category: ".$row['category_desc']."</p>
                                    <p class = 'company_joinDt'>Join Date: ".$row['company_joinDt']."</p>
                                    <p class = 'company_ssm'>SSM: ".$row['company_ssm']."</p>
                                    <p class = 'company_address'>Address: ".$row['company_address']."</p>
                                </div>

                                ";                                
                            } else{
                                echo "

                                <div class='shadow companyDiv' company_id='".$row['company_id']."'>
                                    <div class='row'>
                                        <div class='col'>
                                            <h1 class='text-left companyDivTitle'>".$row['company_name']."</h1>
                                        </div>
                                        <div class='col-2 d-flex justify-content-end'>
                                            <div class='d-lg-flex' style='z-index:5'>
                                                <button class='btn btn-default' onclick = openEditPanel(this);event.stopPropagation();><i class='material-icons' parent_company='".$row['company_id']."'>edit</i></button>
                                            </div>
                                        </div>
                                    </div>                    
                                    <p class = 'company_cat' catId='".$row['category_id']."'>Category: ".$row['category_desc']."</p>
                                    <p class = 'company_joinDt'>Join Date: ".$row['company_joinDt']."</p>
                                    <p class = 'company_ssm'>SSM: ".$row['company_ssm']."</p>
                                    <p class = 'company_address'>Address: ".$row['company_address']."</p>
                                </div>

                                ";      

                            }

                        }
                    }

                    echo "

                        <div class='shadow d-flex flex-column justify-content-center align-items-center addCompanyDiv' id='addCompanyDiv'>
                            <i class='fa fa-plus d-lg-flex justify-content-lg-center' style='font-size: 44px;'></i>
                            <h1 class='text-center companyDivTitle' style='padding: 0;font-weight: 200'>New Company</h1>
                        </div>



                    ";
                } else{

                    $sql = "SELECT *
                            FROM tb_access
                            JOIN tb_company ON tb_access.access_company_id = tb_company.company_id
                            JOIN tb_category ON tb_category.category_id = tb_company.company_cat
                            WHERE access_user_id = '$user_id'";
                        $result = mysqli_query($con,$sql) or die(mysqli_error($con));
                        while($row = mysqli_fetch_assoc($result)){

                            if($row['company_id'] != 0 && $row['category_desc'] != 'Deactivated' ){
                                echo "

                                <div class='shadow companyDiv' company_id='".$row['company_id']."'>
                                    <div class='row'>
                                        <div class='col'>
                                            <h1 class='text-left companyDivTitle'>".$row['company_name']."</h1>
                                        </div>
                                        <div class='col-2 d-flex justify-content-end'>
                                            
                                        </div>
                                    </div>                    
                                    <p>Category: ".$row['category_desc']."</p>
                                    <p>Join Date: ".$row['company_joinDt']."</p>
                                    <p>SSM: ".$row['company_ssm']."</p>
                                    <p>Address: ".$row['company_address']."</p>
                                </div>

                                ";

                            }



                        }

                }
            ?>
            

        </div>
        <div class="sideWrapper">
            
            <div class="editCompanyDiv">
                <div class="shadow editDiv">
                    <div class="row">
                        <div class="col">
                            <div class='row'>
                                <div class='col'>
                                    <h1 class="text-left companyDivTitle" style="padding: 0;">Edit Company</h1>
                                </div>
                                <div class='col-2 d-flex justify-content-end'>
                                    <div class='d-lg-flex'><i class='material-icons'>close</i></div>
                                </div>
                            </div>                           
                            
                            <form method="POST" action="php/companyEdit.php">

                                <div class="form-group"><input type="text" class="form-control" placeholder="Company Name" name="edit_company_name" /></div>
                                <div class="form-group"><textarea class="form-control" placeholder="Address" name="edit_company_address"></textarea></div>
                                <div class="form-group"><input type="text" class="form-control" placeholder="SSM Number" name="edit_company_ssm" /></div>
                                <div class="form-group">
                                    <select name="edit_company_cat" class="form-control">
                                        <?php
                                            $sqlCat = "SELECT category_id,category_desc
                                                    FROM tb_category
                                                    WHERE category_level ='company'";

                                            $resultCat = mysqli_query($con,$sqlCat);

                                            while($rowCat = mysqli_fetch_assoc($resultCat)){
                                                echo "<option value='".$rowCat['category_id']."'>".$rowCat['category_desc']."</option>";
                                            }
                                         ?>
                                    </select>
                                </div>
                                <input type="hidden" class="form-control" placeholder="Company Name" name="edit_company_id"/>
                                <div style="display: flex;justify-content: flex-end;width: 100%;padding: 1rem 0 0 0;">
                                    <button class="btn btn-primary" type="submit">Edit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <p></p>
                </div>

            </div>


        </div>

    </div>



    <div role="dialog" tabindex="-1" class="modal fade show" id="addCompanyModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Company</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <p>Some Important Instructions.</p>
                    <form method="POST" action="assets/php/companyAdd.php" id="addCompanyForm">
                        <div class="form-group"><input type="text" class="form-control" placeholder="Company Name" name="company_name" /></div>
                        <div class="form-group"><textarea class="form-control" placeholder="Address" name="company_address"></textarea></div>
                        <div class="form-group"><input type="text" class="form-control" placeholder="SSM Number" name="company_ssm" /></div>
                        <div class="form-group">
                        <select name="company_cat" class="form-control">
                            <?php
                                $sqlCat = "SELECT category_id,category_desc
                                        FROM tb_category
                                        WHERE category_level ='company'";

                                $resultCat = mysqli_query($con,$sqlCat);

                                while($rowCat = mysqli_fetch_assoc($resultCat)){
                                    if($rowCat['category_desc'] == 'Deactivated'){

                                    }else{
                                        echo "<option value='".$rowCat['category_id']."'>".$rowCat['category_desc']."</option>";
                                    }
                                }
                             ?>
                        </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" list="user_name_list" id="userNameDisplay" placeholder="Company Owner">
                            <input type="text" name="add_user_id" id="addUserId" hidden="true">
                        </div>
                        <datalist id="user_name_list">      <!-- Give autofill suggestion for adding staff -->

                            <?php

                                $sql = "SELECT user_name,user_id
                                        FROM tb_user";

                                $result = mysqli_query($con,$sql);

                                while($row = mysqli_fetch_assoc($result)){
                                    echo "<option value='".$row['user_name']."' userId = '".$row['user_id']."'></option>";
                                }
                            ?>
                        </datalist>     
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="button" id="addCompanyButton">Add</button>
                </div>
            </div>
        </div>
    </div>


    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>


    <script type="text/javascript">


        $('.companyWrapper').css('width','100%');
        $('.companyWrapper').css('overflow-x','hidden');

        $('.sideWrapper').css('visibility','hidden');
        
        $('#addCompanyDiv').on('click',function(){
            $('#addCompanyModal').modal('show');
        })



        $(document).on('input','#userNameDisplay',function(){   ///Prepare form for adding user
            var exist = false;
            for(var i=0;i< $('#user_name_list').find('option').length;i++){
                if($(this).val() == $($('#user_name_list').find('option')[i]).attr('value')){
                    $('#addUserId').val($($('#user_name_list').find('option')[i]).attr('userId'));
                    exist = true;
                }
            }
            if(!exist){
                $('#addUserId').val('');
            }
        });

        $(document).on('click','#addCompanyButton',function(){
            $('#addCompanyForm').submit();
        });

        // $(document).on('click','.material-icons:contains("edit")',function(){


        // })

        function openEditPanel(e){

            if($('.sideWrapper').css('visibility') == 'hidden'){

            }else{
                $('.editDiv').addClass('animated bounce');
            }

            $('.editDiv')[0].addEventListener('animationend', function() {
                $('.editDiv').removeClass('animated bounce');
            })

            var compId = $(e).find('.material-icons').attr('parent_company');
            var comp = $('[company_id='+ compId +']');

            $('[name="edit_company_name"]').val($(comp).find('.companyDivTitle').text());
            $('[name="edit_company_cat"]').val($(comp).find('.company_cat').attr('catId'));
            $('[name="edit_company_address"]').val($(comp).find('.company_address').text().replace('Address: ',''));
            $('[name="edit_company_ssm"]').val($(comp).find('.company_ssm').text().replace('SSM: ',''));
            $('[name="edit_company_id"]').val(compId);

            $('.sideWrapper').css('visibility','visible');
            $('.companyWrapper').css('width','60%');
            $('.sideWrapper').css('width','40%');


        }

        $(document).on('click','.material-icons:contains("close")',function(){
            $('.companyWrapper').css('width','100%');
            $('.sideWrapper').css('visibility','hidden');
            $('.sideWrapper').css('width','0');
        })

        $(document).on('click','.companyDiv',function(){
            var compId = $(this).attr('company_id');
            location.href = 'companyDashboard.php?company=' + compId ;
        })

        console.log('<?php echo $row['access_level'] ?>');

        if($('.companyDiv').length == 0 && ('<?php echo $access_level ?>' != '5')){
            $('.companyWrapper').append('<div><h2>Welcome to Farvo!</h2><p>Currently you are not associated to any company. You can ask the company admin to add you into a their team.If you believe this is an error, please contact the support team.</p><br><p>Meanwhile, would you like to read the instructions?</p></div>')
        }

        var url_string = window.location.href;
        var url = new URL(url_string);
        var denied = url.searchParams.get("denied");
        if(denied == 1){
            alert('Access Denied!');
        }


    </script>



</body>

</html>