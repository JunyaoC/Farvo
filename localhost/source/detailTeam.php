<?php

	session_start();

    include('assets/php/dbconnect.php');
    date_default_timezone_set("Asia/Kuala_Lumpur");

    $company_id = $_POST['detail'];
    $user_id = $_SESSION['user_id'];

	$sql = "SELECT * FROM tb_access
            JOIN tb_company ON tb_company.company_id = tb_access.access_company_id
            WHERE access_user_id = '$user_id' AND access_company_id = '$company_id'";

    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);

    $found_company_id = $row['company_id'];
    $farmCount = 0;
    $projectCount = 0;

    // $sqlCoop = "SELECT * FROM tb_coop WHERE coop_id = '$coop_id'";
    // $resultCoop = mysqli_query($con,$sqlCoop);
    // $rowCoop = mysqli_fetch_assoc($resultCoop);

?>
   
<h3 class="text-center">Team</h3>

        <div class="row" style="margin: 0;">
            <div class="col-sm-12 col-md-8" style="padding: 1rem;">

                <div id="staffData"></div>
                                                
            </div>

            <div class="col-sm-12 col-md-4" style="padding: 1rem;">

                <?php
                    if($_SESSION['accessLevel'] == 4){
                        echo '
                                       <form method="POST" action="assets/php/staffAdd.php" id="formAddUser">
                    <div class="form-group">
                        <input class="form-control" type="text" name="add_company_id" id="addCompanyId" hidden="true" value="'.$found_company_id.'">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" list="user_name_list" id="userNameDisplay" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="add_user_id" id="addUserId" hidden="true">                                
                    </div>
                    <p>Position:</p>
                    <div class="form-group">
                        <select class="form-control" name="add_access_level">
                            <option value="2">Stakeholder</option>
                            <option value="4">Admin</option>
                            <option value="3">Staff</option>
                            <option value="1">Farmer</option>
                        </select>
                    </div>
                </form>
                    <div>
                        <button class="btn btn-primary userAdd">Add User</button>
                    </div>
                        ';

                    }
                ?>

 

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
                
            </div>


        </div>

    <script type="text/javascript">

        var editCompId;
        var editUserId;


        $('#staffData').html('<div class="lds-ring"><div></div><div></div><div></div><div></div></div>');

        function loadStaff(){
            $.post('assets/php/staffView.php',{company_id:'<?php echo $found_company_id; ?>',accessLevel:'<?php echo $_SESSION['accessLevel']; ?>'},function(){
            }).done(function(data){            
                $('#staffData').html(data);
            });
        }

        $(document).ready(function(){
            loadStaff();
        });

        $(document).on('click','.userAdd',function(){

            var staffData = $('#formAddUser').serialize();

            $('#formAddUser').find('input').attr('disabled','true');
            $('#formAddUser').find('textarea').attr('disabled','true');
            $('#formAddUser').find('select').attr('disabled','true');

            $('.userAdd').attr('disabled','true');
            $('.userAdd').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>')

            $.ajax({
                url: 'assets/php/staffAdd.php',
                data: staffData,
                type: 'POST'
            }).done(function(data){
                if(data == 'userexist'){
                    alert('Could not add user.');
                }
                loadStaff();
                $('#formAddUser').find('input').removeAttr('disabled');
                $('#formAddUser').find('textarea').removeAttr('disabled');
                $('#formAddUser').find('select').removeAttr('disabled');
                $('.userAdd').removeAttr('disabled');
                $('.userAdd').html('Add');
            })
            
        });

        $(document).on('click','.userEditAccess',function(){
            editCompId = $(this).attr('compId');
            editUserId = $(this).attr('userId');

            $('#confirmOptionModal').modal('show');

        });

        $(document).on('click','.confirmEditAccess',function(){
            var newLevel = $('#confirmSelect').val();

            //can change to some better data input here

            $.post('assets/php/staffEdit.php',{op:'edit',compId:editCompId,userId:editUserId,level:newLevel},function(){

            }).done(function(data){
                window.location.reload(true);
            })
        })

        $(document).on('click','.userRemove',function(){

            if(confirm('Confirm Remove User?')){
                editCompId = $(this).attr('compId');
                editUserId = $(this).attr('userId');

                $('#staffData').html('<div class="lds-ring"><div></div><div></div><div></div><div></div></div>');


                $.post('assets/php/staffEdit.php',{op:'remove',compId:editCompId,userId:editUserId},function(){

                    }).done(function(data){
                        window.location.reload(true);
                    })
                }            

            //can change to some better data input here

        });

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
        })





    </script>