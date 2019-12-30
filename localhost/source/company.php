<?php

session_start();


    include('assets/php/dbconnect.php');
    include('header.php');

    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    } else{
        header('Location: index.php');
    }

    $sqlFetchCompany = "SELECT * FROM tb_company JOIN tb_access ON tb_company.company_id = tb_access.access_company_id WHERE tb_access.access_user_id = '$user_id' AND tb_company.company_id = '0'";
    $resultFetchCompany = mysqli_query($con,$sqlFetchCompany);

    if(mysqli_num_rows($resultFetchCompany) > 0){
        $systemAdmin = 1;
    }else{
        $systemAdmin = 0;
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

        <div class="companyWrapper row" style="width: 100%;padding: 0;margin: 0;">
           

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
                    
                        </select>
                        </div>
                        <div class="form-group">
                            <label id="company_user_name">Company Owner:</label>
                            <p style="margin: 0;font-size: 0.7rem;font-family: Cabin, sans-serif;font-weight: 900;">Email Address</p>
                            <input type="text" class="form-control" list="user_name_list" id="userNameDisplay" placeholder="Enter email address">
                            <input type="text" name="add_user_id" id="addUserId" hidden="true">
                        </div>
                        <datalist id="user_name_list">      <!-- Give autofill suggestion for adding staff -->
                        </datalist>     
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="button" id="addCompanyConfirm">Add</button>
                </div>
            </div>
        </div>
    </div>

    <div role="dialog" tabindex="-1" class="modal fade show" id="editCompanyModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Company</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <p>Some Important Instructions.</p>
                    <form method="POST" action="assets/php/companyEdit.php" id="editCompanyForm">

                        <div class="form-group"><input type="text" class="form-control" placeholder="Company Name" name="edit_company_name" /></div>
                        <div class="form-group"><textarea class="form-control" placeholder="Address" name="edit_company_address"></textarea></div>
                        <div class="form-group"><input type="text" class="form-control" placeholder="SSM Number" name="edit_company_ssm" /></div>
                        <div class="form-group">
                            <select name="edit_company_cat" class="form-control"></select>
                        </div>
                        <input type="hidden" class="form-control" placeholder="Company Name" name="edit_company_id"/>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="button" id="editCompanyConfirm">Edit</button>
                </div>
            </div>
        </div>
    </div>

    <div role="dialog" tabindex="-1" class="modal fade show" id="userManualModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">User Manual</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <p>Click to view user manual for corresponding roles.</p>

                    <?php
                        if($systemAdmin == 1){
                            echo '<p><a href="assets/userManual/SystemAdminUserManual.pdf" target="_blank">System Admin</a></p>';
                        }
                    ?>

                    
                    <p><a href="assets/userManual/StakeholderUserManual.pdf" target="_blank">Stakeholder</a></p>
                    <p><a href="assets/userManual/CompanyAdminUserManual.pdf" target="_blank">Company Admin</a></p>
                    <p><a href="assets/userManual/CompanyStaffUserManual.pdf" target="_blank">Company Staff</a></p>
                    <p><a href="assets/userManual/FarmerUserManual.pdf" target="_blank">Farmer</a></p>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>


    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>


    <script type="text/javascript">

    	if(window._company == null){

    		window._company = [];

    		

    	}

        if(window.user == null){

            $.ajax({
                method:'GET',
                url:'assets/php/userGet.php',
            }).done(function(data){

                $('#user_name_list').empty();

                window.user = JSON.parse(data);
                for(var i=0;i<window.user.length;i++){

                    $('#user_name_list').append("<option value='"+window.user[i].user_email+"' userId = '"+window.user[i].user_id+"'></option>");


                }

            });

        }



    	if(typeof(window.company) != 'function'){

    		window.company = class company {

    			constructor(obj){
    				this.company_name = obj.company_name;
    				this.company_id  = obj.company_id;
    				this.company_address  = obj.company_address;
    				this.company_ssm  = obj.company_ssm;
    				this.company_joinDt  = obj.company_joinDt;
    				this.company_cat  = obj.company_cat;
    				this.access_level = obj.access_level;
    				this.company_card = obj.company_card;
    			}
    		}
            fetchCompany();
    	}


        $('.companyWrapper').css('width','100%');
        $('.companyWrapper').css('overflow-x','hidden');

        $('.sideWrapper').css('visibility','hidden');
        
        $(document).on('click','.addCompanyButton',function(){
            $('#addCompanyModal').modal('show');
            $('#addCompanyForm').find('input').removeAttr('disabled');
            $('#addCompanyForm').find('textarea').removeAttr('disabled');
            $('#addCompanyForm').find('select').removeAttr('disabled');
            $('#addCompanyConfirm').removeAttr('disabled');
            $('#addCompanyConfirm').html('Start');
        })

        $(document).on('click','#addCompanyConfirm',function(){

            var companyData = $('#addCompanyForm').serialize();

            $('#addCompanyForm').find('input').attr('disabled','true');
            $('#addCompanyForm').find('textarea').attr('disabled','true');
            $('#addCompanyForm').find('select').attr('disabled','true');

            $('#addCompanyConfirm').attr('disabled','true');
            $('#addCompanyConfirm').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>')

            $.ajax({
                url:'assets/php/companyAdd.php',
                type:'POST',
                data: companyData
            }).done(function(data){
                $('#addCompanyModal').modal('hide');
                fetchCompany();
            });


            
        });

        $(document).on('click','.editCompanyButton',function(){

            var thisCompany = $(this).attr('company_id');

            for(var i=0;i<window._company.length;i++){

                if(window._company[i].company_id == thisCompany){

                    $('[name="edit_company_name"]').val(window._company[i].company_name);
                    $('[name="edit_company_address"]').val(window._company[i].company_address);
                    $('[name="edit_company_ssm"]').val(window._company[i].company_ssm);
                    $('[name="edit_company_cat"]').val(window._company[i].company_cat);
                    $('[name="edit_company_id"]').val(window._company[i].company_id);

                }
            }

            $('#editCompanyModal').modal('show');
        })

        $(document).on('click','#editCompanyConfirm',function(){
            $('#editCompanyForm').submit();
        });


        $(document).on('input','#userNameDisplay',function(){   ///Prepare form for adding user
            var exist = false;
            for(var i=0;i< window.user.length;i++){
                if($(this).val() == window.user[i].user_email){
                    $('#addUserId').val(window.user[i].user_id);
                    $('#company_user_name').text('Company Owner: ' + window.user[i].user_name);
                    exist = true;
                }
            }
            if(!exist){
                $('#addUserId').val('');
            }
        });

        $(document).on('click','.companyDiv',function(){
            var compId = $(this).attr('company_id');
            location.href = 'companyDashboard.php?company=' + compId ;
        });


        if(typeof(window.category) != 'function'){
            updateCategory();
        }

        function fetchCompany(){

            $.ajax({
                method:'GET',
                url:'assets/php/companyGet.php',
                data: {user_id:'<?php echo $user_id ?>'},
                context: window._company
            }).done(function(data){

                $('.companyWrapper').empty();

                if('<?php echo($systemAdmin)?>' == '1'){
                    $('.companyWrapper').append('<div class="col-md-3 col-sm-12 addCompanyButton" style="margin:1rem 0;display:flex;justify-content:center;padding:0;"> <div class="card" style="width:90%;"> <div class="card-body d-flex justify-content-center align-items-center flex-column"><i class="fa fa-plus" style="font-size: 44px;"></i><h5 class="card-title text-center" style="margin:0;padding:1rem 0;">Add New Company</h5></div> </div> </div>');
                }

                var response = JSON.parse(data);

                for(var i=0;i<response.length;i++){

                    var newCompany = new company(response[i]);
                    this.push(newCompany);
                    $('.companyWrapper').append(window._company[window._company.length - 1].company_card);

                }

                $('.addCompanyButton').height($($('.companyCol')[0]).height());

                console.log(window._company);

            });

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

                $('select[name="company_cat"]').empty();
                $('select[name="edit_company_cat"]').empty();

                for(var i=0;i<window.category.length;i++){
                    if(window.category[i].category_level == 'company'){
                        $('select[name="company_cat"]').append('<option value="'+window.category[i].category_id+'">'+window.category[i].category_desc+'</option>');
                        $('select[name="edit_company_cat"]').append('<option value="'+window.category[i].category_id+'">'+window.category[i].category_desc+'</option>');
                    }
                }

                

                // $('select[name="cost_category"]').empty();

                // for(var i=0;i<window.category.length;i++){
                //     if(window.category[i].category_level == 'cost'
                //         && window.category[i].category_desc != 'day o chick'
                //         && window.category[i].category_desc != 'feed'

                //         ){
                //         $('select[name="cost_category"]').append('<option value="'+window.category[i].category_id+'">'+window.category[i].category_desc+'</option>');
                //     }
                // }

                // $('select[name="edit_farm_cat"]').empty();

                // for(var i=0;i<window.category.length;i++){
                //     if(window.category[i].category_level == 'farm'){
                //         $('select[name="edit_farm_cat"]').append('<option value="'+window.category[i].category_id+'">'+window.category[i].category_desc+'</option>');
                //     }
                // }



            });

        }



        var url_string = window.location.href;
        var url = new URL(url_string);
        var denied = url.searchParams.get("denied");
        if(denied == 1){
            alert('Access Denied!');
        }

        $(document).on('click','.userManualButton',function(){
            $('#userManualModal').modal('show');
        })


    </script>

    <?php
        include 'assets/php/footer.php';
    ?>

</body>

</html>