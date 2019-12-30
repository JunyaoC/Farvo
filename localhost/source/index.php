<?php

    session_start();
    if(isset($_SESSION["user_id"])){
        //do anything you like eg: greet user, set pemission etc
        header('Location:company.php');
    };
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>FARVO 1.0</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cabin">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</head>

<body id="indexBody">
    <!-- <div class="mainWrapper" style="background-color: rgb(234,234,234);">
        <div class="shadow mainCard">
            <div class="d-flex align-items-center formDiv">
            </div>
            <div class="d-lg-flex justify-content-lg-center align-items-lg-start infoDiv">
            </div>
        </div>
    </div> -->
    <div class="jumbotron jumbotron-fluid">
  <div class="container">
    <div class="text-center" style="padding: 1rem 1rem 0 1rem; color: #393E41; font-family: Cabin, sans-serif; font-weight: 900;">
        <h2 style="font-size: 5rem;">FARVO</h2>
        <p>Farm + Revolution</p>
    </div>
  </div>
</div>

    <div class="mainWrapper">
        <div class="shadow mainCard">
            <div class="d-flex align-items-center formDiv" style="background-color:#E6E6E6;">
            </div>
            <div class="infoDiv">
            </div>
        </div>
    </div>

    <div class="footer" style="position: fixed;bottom: 0;width:100%;display: flex;justify-content: center;flex-direction: column;align-items: center;">
        <img src="assets/img/logo.png" style="max-width:60px"class="img-responsive">
        <p>Developed by team Zettabyte from Bachelor Of Computer Science ( Data Engineering ) 2U2I study mode</p>
    </div>
    
    <script type="text/javascript">

        var signin = true;

        var signinForm,signinInfo,registerForm,registerInfo;

        var signinForm = document.createElement('DIV');
        $(signinForm).load('signinForm.html');
        $(signinForm).addClass('divContent');

        var signinInfo = document.createElement('DIV');
        $(signinInfo).load('signinInfo.html');
        $(signinInfo).addClass('divContent');

        var registerForm = document.createElement('DIV');
        $(registerForm).load('registerForm.html');
        $(registerForm).addClass('divContent');

        var registerInfo = document.createElement('DIV');
        $(registerInfo).load('registerInfo.html');
        $(registerInfo).addClass('divContent');


        $('.formDiv').append(signinForm);
        $('.infoDiv').append(signinInfo);



        $(document).ready(function(){

            $(document).on('click','#formButton',function(){

                if(signin){
                    $('.formDiv').animate({ left: '+=30%'  });
                    $('.formDiv').css('border-radius','0 0.5rem 0.5rem 0');
                    $('.infoDiv').animate({ left: '-=70%'  });
                    signin = false;
                    $('.formDiv').empty();
                    $('.infoDiv').empty();
                    $('.formDiv').append(registerForm);
                    $('.infoDiv').append(registerInfo);

                }else{
                    $('.formDiv').animate({ left: '-=30%'  });
                    $('.formDiv').css('border-radius','0.5rem 0 0 0.5rem');
                    $('.infoDiv').animate({ left: '+=70%'  });
                    signin = true;
                    $('.formDiv').empty();
                    $('.infoDiv').empty();
                    $('.formDiv').append(signinForm);
                    $('.infoDiv').append(signinInfo);
                }
            })




        });

        $(document).on('click','#registerLink',function(){
            $('.formDiv').empty();
            $('.formDiv').append(registerForm);
        });

        $(document).on('click','#signinLink',function(){
            $('.formDiv').empty();
            $('.formDiv').append(signinForm);
        });



    </script>


</body>

</html>