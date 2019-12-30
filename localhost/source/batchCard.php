<?php

    session_start();
    date_default_timezone_set("Asia/Kuala_Lumpur");

    $batch_uid = $_POST['detail'];

?>



<link rel="stylesheet" href="assets/css/calendar.css">

<style type="text/css">
::-webkit-scrollbar {
    display: none;
}

ul,
ol,
li {
    list-style: none;
    padding: 0;
    margin: 0;
}


</style>

<body style="min-height: 100vh;height: 100%;">
    <div style="padding: 1rem;background-color: #e8e8e8;height: 100vh;">
        <div class="row" style="height: 100%;">
            <div class="col-3" style="background-color: white;margin:-1rem 0 -1rem 0;">
                <div class="row" style="height: auto;padding: 1rem;">
                    <div class="col">
                        <div style="height: 100%;">
                            <h1 id="batchNameDisplay"></h1>
                        </div>
                    </div>
                </div>
                <div style="display: flex;justify-content: center;width: 100%;">
                    <div id="one"></div>
                </div>
                <div class="eventViewDiv">
                    <div class="eventViewDate">
                        <div style="display: flex;">
                            <h3 class="evDate"></h3>
                            <div style="padding-left: 1rem;">
                                <p class="evMonth"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <h3>Events</h3>                            
                        </div>
                        <div class="col-4 d-flex justify-content-center">
                            <div>
                                <button class="btn btn-primary btn-sm" id="addEventButton" event_date="">New</button>
                            </div>
                        </div>
                    </div>
                    <div id="eventListDiv"></div>
                </div>
            </div>
            <div class="col-5">
                <div class="timelineDiv" style="overflow-y: scroll;width: 100%;height: 95vh;position: absolute;top: 0;padding-bottom: 2rem;"></div>
            </div>
            <div class="col-4" style="padding-right: 2rem;">
                <div class="row">
                    <div class="col" style="padding: 0.25rem;">
                        <div class="border rounded shadow-sm" style="background-color: #ffffff;height: 43vh;">
                            <div class="canvasFrameBird">
                                <canvas id="birdCanvas"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="min-height: 20vh;">
                    <div class="col" style="padding: 0.25rem;">
                        <div class="border rounded shadow-sm" style="background-color: #ffffff;height: 100%;">
                            <div class="text-center titleRow" style="margin: 0 1rem;">
                                <h6 class="text-center" style="color: rgb(115,115,115);font-family: Cabin, sans-serif;font-weight: bold;">Livabilty</h6>
                            </div>
                            <div class="text-center" style="font-family: Cabin, sans-serif;font-weight: bold;">
                                <h1 style="font-size: 3rem;display: inline;" class="livabilityPercentage"></h1>
                                <h5 id style="display: inline;">%</h5>
                                <p class="livabilityTotal"></p>
                                <div class="row" style="font-family: Cabin, sans-serif;font-weight: bold;width: 100%;margin: 0;">
                                    <div class="col-4 text-center">
                                        <p style="font-size: 0.8rem;margin: 0;">Total<br>Death</p>
                                        <h4 id="sumDeath"></h4>
                                    </div>
                                    <div class="col-4 text-center">
                                        <p style="font-size: 0.8rem;margin: 0;">Total<br>Culls</p>
                                        <h4 id="sumCull"></h4>
                                    </div>
                                    <div class="col-4 text-center">
                                        <p style="font-size: 0.8rem;margin: 0;">Total<br>Catch</p>
                                        <h4 id="sumCatch"></h4>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="col" style="padding: 0.25rem;">
                        <div class="border rounded shadow-sm" style="background-color: #ffffff;height: 100%;">
                            <div class="text-center titleRow" style="margin: 0 1rem;">
                                <h6 class="text-center" style="color: rgb(115,115,115);font-family: Cabin, sans-serif;font-weight: bold;">FCR</h6>
                            </div>
                            <div class="fcrDiv"></div>
                        </div>
                    </div>
                </div>
<!--                 <div class="row">
                    <div class="col" style="padding: 0.25rem;height: 20vh;">
                        <div class="border rounded shadow-sm" style="background-color: #ffffff;height: 100%;"></div>
                    </div>
                    <div class="col" style="padding: 0.25rem;height: 20vh;">
                        <div class="border rounded shadow-sm" style="background-color: #ffffff;height: 100%;"></div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>

    <script src="assets/js/calendar.js"></script>
    <script type="text/javascript">

        if(window._dashboard == null){
            window._dashboard = new dashboard('<?php echo $company_id ?>','<?php echo $access_level ?>');
        }

        window.view_batch = null;

        for(var obj in window._dashboard.farm_list){

            for(var i=0;i<window._dashboard.farm_list[obj].cycle_list.length;i++){

                for(var j=0;j<window._dashboard.farm_list[obj].cycle_list[i].batch_list.length;j++){
                    if(window._dashboard.farm_list[obj].cycle_list[i].batch_list[j].batch_uid == '<?php echo $batch_uid ?>'){
                        window.view_batch = window._dashboard.farm_list[obj].cycle_list[i].batch_list[j];
                        window.view_batch['batch_farm_id'] = obj;
                        break;
                    }
                }
            }
        }

        $('#batchNameDisplay').text(window.view_batch.batch_name);

        if(window.monthNames == null){
            window.monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        }

        if(window.dayName == null){
            window.dayName = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        }

        if(window.eventStateDesc == null){
            window.eventStateDesc = ["Completed","Pending","Cancelled"];
        }

        var eventObj = {};
        var data = [];

        for(var i=0;i<window.view_batch.batch_event.length;i++){

            var eventType = getCategoryDesc('event',window.view_batch.batch_event[i].event_type);
            var eventDesc = '';
            switch(eventType){

                case 'weight':
                    eventDesc = 'Weight Measurement';
                    break;

            }


            if(typeof(eventObj[window.view_batch.batch_event[i].event_date]) !== 'undefined'){
                eventObj[window.view_batch.batch_event[i].event_date] = eventObj[window.view_batch.batch_event[i].event_date] + eventDesc;
            } else{
                eventObj[window.view_batch.batch_event[i].event_date] = eventDesc;
            }
        }

        for(var obj in eventObj){
            var newEventPop = {
                date: obj,
                value: eventObj[obj]
            }
            data.push(newEventPop);
        }



        $(document).ready(function(){
            $.post('timeline.php',{},function(data){
                $('.timelineDiv').html(data);
            })

            var now = new Date();
            var year = now.getFullYear();
            var month = now.getMonth();
            var date = now.getDate();

            var today = year + '/' + month + '/' + date;
            var todayDash = year + '-' + month + '-' + date;
            $('li[data-calendar-day="'+today+'"]').click();


        })

        var $ca = $('#one').calendar({
            // view: 'month',
            width: 240,
            height: 240,
            // startWeek: 0,
            // selectedRang: [new Date(), null],
            data: data,
            monthArray: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            date: new Date(),
            onSelected: function (view, date, data) {

                var selectedDate = new Date(date);
                var textDate = selectedDate.getFullYear() + '-' + ( selectedDate.getMonth() + 1 ) + '-' + selectedDate.getDate();

                $('.evDate').text(selectedDate.getDate());
                $('.evMonth').text(window.monthNames[selectedDate.getMonth()]);
                $('#addEventButton').attr('event_date',textDate);

                showEventList(textDate);

                console.log('selected!');



            },
            viewChange: function (view, y, m) {
                console.log(view, y, m)

            }
        });


        $('#addEventButton').on('click',function(){
            $('.eventModalDate').text($(this).attr('event_date'));
            $('#addEventModal').find('input[name="event_date"]').val($(this).attr('event_date'));   
            $('#addEventModal').modal('show');
            $('#addEventForm').find('input').removeAttr('disabled');
            $('#addEventForm').find('textarea').removeAttr('disabled');
            $('#addEventForm').find('select').removeAttr('disabled');
            $('#addEventConfirm').removeAttr('disabled');
            $('#addEventConfirm').html('Add');
        })

        $('#addEventConfirm').on('click',function(){
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
                    $('#addEventModal').modal('hide');
                    $('.detailBackground').click();
                    $('.detailTrigger[detail_id="'+window.view_batch.batch_uid+'"]');
                    window._dashboard.generateDashboard();
                }
            });
        })

        function showEventList(textDate){

            $('#eventListDiv').empty();

            if(window.view_batch){
                for(var i=0;i<window.view_batch.batch_event.length;i++){

                    var eventType = window.view_batch.batch_event[i].event_type;
                    eventType = getCategoryDesc('event',eventType);

                    var eventState = Number(window.view_batch.batch_event[i].event_state);
                    eventState = window.eventStateDesc[eventState];

                    var eventNote = window.view_batch.batch_event[i].event_note;
                    if(!eventNote){
                        eventNote = 'No Remarks.';
                    }

                    if(window.view_batch.batch_event[i].event_date == textDate){


                        switch(eventType){

                            case 'weight':
                                if(eventState == 'Pending'){
                                    $('#eventListDiv').append('<div class="shadow event pending"> <div class="row"> <div class="col-8 d-flex justify-content-start align-items-center"> <h5>Weight Measure</h5> </div> <div class="col-4"> <p style="margin: 0;">Status</p> <h5>'+eventState+'</h5> </div> </div> <h6>Remarks</h6> <p>'+eventNote+'</p> </div>');
                                }

                                if(eventState == 'Completed'){
                                    $('#eventListDiv').append('<div class="shadow event completed"> <div class="row"> <div class="col-8 d-flex justify-content-start align-items-center"> <h5>Weight Measure</h5> </div> <div class="col-4"> <p style="margin: 0;">Status</p> <h5>'+eventState+'</h5> </div> </div> <h6>Remarks</h6> <p>'+eventNote+'</p> </div>');
                                }

                                break;

                        }


                    }

                    

                }

            }




        }


    </script>
    


</body>

</html>