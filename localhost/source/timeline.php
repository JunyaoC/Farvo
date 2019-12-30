<?php

    date_default_timezone_set("Asia/Kuala_Lumpur");

?>



<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>

  /* The actual timeline (the vertical ruler) */
  .timeline {
    position: absolute;
    width: 100%;
    top: 0;
    margin: 0 auto;
    min-height: 100vh;
  }

  /* The actual timeline (the vertical ruler) */
  .timeline::after {
    content: '';
    position: absolute;
    width: 6px;
    background-color: white;
    top: 0;
    bottom: 0;
    left: 50%;
    margin-left: -3px;
  }

  /* Container around content */
  .timelineContainer {
    padding: 10px 40px;
    position: relative;
    background-color: inherit;
    width: 50%;
  }

  /* The circles on the timeline */
  .timelineContainer::after {
    content: '';
    position: absolute;
    width: 25px;
    height: 25px;
    right: -13px;
    background-color: white;
    border: 4px solid #FF9F55;
    top: 15px;
    border-radius: 50%;
    z-index: 1;
  }

  /* Place the container to the left */
  .left {
    left: 0;
  }

  /* Place the container to the right */
  .right {
    left: 50%;
  }

  /* Add arrows to the left container (pointing right) */
  .left::before {
    content: " ";
    height: 0;
    position: absolute;
    top: 22px;
    width: 0;
    z-index: 1;
    right: 30px;
    border: medium solid white;
    border-width: 10px 0 10px 10px;
    border-color: transparent transparent transparent white;
  }

  /* Add arrows to the right container (pointing left) */
  .right::before {
    content: " ";
    height: 0;
    position: absolute;
    top: 22px;
    width: 0;
    z-index: 1;
    left: 30px;
    border: medium solid white;
    border-width: 10px 10px 10px 0;
    border-color: transparent white transparent transparent;
  }

  /* Fix the circle for containers on the right side */
  .right::after {
    left: -13px;
  }

  /* The actual content */
  .content {
    padding: 1rem;
    background-color: white;
    position: relative;
    border-radius: 6px;
  }

  .feed_input{
    margin: 0;
  }



  /* Media queries - Responsive timeline on screens less than 600px wide */
  @media screen and (max-width: 600px) {

      .timeline{
        position: relative;
        top: 0;
        
      }

      /* Place the timelime to the left */
      .timeline::after {
        left: 31px;
      }
      
      /* Full-width containers */
      .container {
        width: 100%;
        padding-left: 70px;
        padding-right: 25px;
      }

      .timelineContainer {
        padding: 10px 40px;
        position: relative;
        background-color: inherit;
        width: 100%;
      }
      
      /* Make sure that all arrows are pointing leftwards */
      .timelineContainer::before {
        left: 60px;
        border: medium solid white;
        border-width: 10px 10px 10px 0;
        border-color: transparent white transparent transparent;
      }

      /* Make sure all circles are at the same spot */
      .left::after, .right::after {
        left: 15px;
      }
      
      /* Make all right containers behave like the left ones */
      .right {
        left: 0%;
      }

      .eventViewDiv{
        height: 100%;
      }

  }
</style>

<div class="timeline">

 

</div>

  
 
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-colorschemes"></script>
<script type="text/javascript">

  var accessLevel = window.accessLevel;

var pendingUpdateRow = '<div class="row"><div class="col"><h6>Pending Update</h6></div><div class="col"><button class="btn btn-primary btn-sm batchUpdateButton">Update</button></div></div>';

window.houseArr = [];
var house_id_arr = [];

for(var i=0;i<window.view_batch.batch_record.length;i++){
    if(house_id_arr.indexOf(window.view_batch.batch_record[i].bird_house_id) == -1){

        for(var obj in window._dashboard.farm_list){

            for(var j=0;j<window._dashboard.farm_list[obj].house_list.length;j++){
                if(window._dashboard.farm_list[obj].house_list[j].house_id == window.view_batch.batch_record[i].bird_house_id){
                    window.houseArr.push(window._dashboard.farm_list[obj].house_list[j]);
                    house_id_arr.push(window._dashboard.farm_list[obj].house_list[j].house_id);
                }
            }
        }
        
    }
}

    ///////////////// Analytics

    var totalInitBird = 0;

    for(var i=0;i<window.houseArr.length;i++){
        totalInitBird = totalInitBird + Number(window.view_batch.batch_record[i].bird_balance);
    }

    var sumDeath = 0;
    var sumCull = 0;
    var sumCatch = 0;
    var totalInitBird

    for(var i=0;i<window.view_batch.batch_record.length;i++){
        sumDeath = Number(sumDeath) + Number(window.view_batch.batch_record[i].bird_death);
        sumCull = Number(sumCull) + Number(window.view_batch.batch_record[i].bird_cull);
        sumCatch = Number(sumCatch) + Number(window.view_batch.batch_record[i].bird_catch);
    }

    $('#sumDeath').text(sumDeath);
    $('#sumCull').text(sumCull);
    $('#sumCatch').text(sumCatch);

    var livabilityPercentageValue = ((totalInitBird - (sumDeath + sumCull)) / totalInitBird) * 100;
    var totalLost = totalInitBird - (sumDeath + sumCull);

    $('.livabilityPercentage').text(livabilityPercentageValue.toFixed(2));
    $('.livabilityTotal').text(totalLost + '/' + totalInitBird);








    

    /////////////////////
  
if(typeof(window.timelineContainer) !== 'function'){

  window.timelineContainer = class timelineContainer{

    constructor(date,status){
        this.status = status;
        this.date = date;
        this.dateObj = new Date(date);
        this.DOM = document.createElement("DIV");

        this.generateDOM('empty','');
    }

    generateDOM(param,data){

        switch(param){

            case 'empty':
                $(this.DOM).html('<div class="timelineContainer"><div class="content"><div style="display:flex;"><div><h2>'+this.dateObj.getDate()+'</h2></div><div style="padding-left:0.5rem;"><h6 style="line-height:12px;">'+window.monthNames[this.dateObj.getMonth()]+'</h6><h6 style="line-height:12px;">'+ window.dayName[this.dateObj.getDay()]+'</h6></div></div><div class="eventDiv" record_date="'+this.date+'"></div></div></div>');
                break;

            case 'initialize':


                if(accessLevel != 2){
                  var updateRow = '<div class="row"><div class="col"><h6>Pending Update</h6></div><div class="col"><button class="btn btn-primary btn-sm batchAddRecordButton" record_date="'+this.date+'">Update</button></div></div>';
                }else{
                  var updateRow = '';
                }

                $(this.DOM).html('<div class="timelineContainer"><div class="content"><div style="display:flex;"><div><h2>'+this.dateObj.getDate()+'</h2></div><div style="padding-left:0.5rem;"><h6 style="line-height:12px;">'+window.monthNames[this.dateObj.getMonth()]+'</h6><h6 style="line-height:12px;">'+ window.dayName[this.dateObj.getDay()]+'</h6></div></div><div class="eventDiv" record_date="'+recordedDateArr[0]+'"><p>Project Initialized</p><h6>Total Bird: '+data+'</h6>'+updateRow+'</div></div></div>');
                break;

            case 'active':

                if(this.status == 'pending'){

                    if(accessLevel != 2){
                      var updateRow = '<div class="row"><div class="col"><h6>Pending Update</h6></div><div class="col"><button class="btn btn-primary btn-sm batchAddRecordButton" record_date="'+this.date+'">Update</button></div></div>';
                    }else{
                      var updateRow = '';
                    }

                   

                    $(this.DOM).html('<div class="timelineContainer"><div class="content"><div style="display:flex;"><div><h2>'+this.dateObj.getDate()+'</h2></div><div style="padding-left:0.5rem;"><h6 style="line-height:12px;">'+window.monthNames[this.dateObj.getMonth()]+'</h6><h6 style="line-height:12px;">'+ window.dayName[this.dateObj.getDay()]+'</h6></div></div><div class="eventDiv" record_date="'+this.date+'">'+updateRow+'</div></div></div>');
                }

                if(this.status == 'recorded'){

                    var dateTotalBirdDeath = 0;
                    var dateTotalBirdCull = 0;
                    var dateTotalBirdCatch = 0;
                    var dateTotalBirdBalance = 0;
                    var dateTotalBirdWeight = 0;
                    var dateAverageBirdWeight = 0;

                    // console.log(window.view_batch);
                    
                    for(var i=0;i<window.view_batch.batch_record.length;i++){



                        if(window.view_batch.batch_date == this.date){  ///if the timeline container we about to initialise it the first day
     
                            dateTotalBirdDeath = 0;
                            dateTotalBirdCull = 0;
                            dateTotalBirdCatch = 0;
                            dateTotalBirdBalance = 0;                           

                            if(weightEvent(this.date)){

                                dateTotalBirdWeight = 0;
                                dateAverageBirdWeight = 0;

                                for(var j= 0 ;j < window.houseArr.length;j++){      // we only ignore the first few records as it's initialisation record

                                    dateTotalBirdDeath = dateTotalBirdDeath + Number(window.view_batch.batch_record[window.houseArr.length + j].bird_death);
                                    dateTotalBirdCull = dateTotalBirdCull + Number(window.view_batch.batch_record[window.houseArr.length + j].bird_cull);
                                    dateTotalBirdCatch = dateTotalBirdCatch + Number(window.view_batch.batch_record[window.houseArr.length + j].bird_catch);
                                    dateTotalBirdBalance = dateTotalBirdBalance + Number(window.view_batch.batch_record[window.houseArr.length + j].bird_balance);
                                    dateTotalBirdWeight = dateTotalBirdWeight + Number(window.view_batch.batch_record[window.houseArr.length + j].bird_weight);
                                    console.log('weight',window.view_batch.batch_record[window.houseArr.length + j])
                                }

                                dateAverageBirdWeight = dateTotalBirdWeight / window.houseArr.length;

                            }else{
                                for(var j= 0 ;j < window.houseArr.length;j++){      // we only ignore the first few records as it's initialisation record

                                    dateTotalBirdDeath = dateTotalBirdDeath + Number(window.view_batch.batch_record[window.houseArr.length + j].bird_death);
                                    dateTotalBirdCull = dateTotalBirdCull + Number(window.view_batch.batch_record[window.houseArr.length + j].bird_cull);
                                    dateTotalBirdCatch = dateTotalBirdCatch + Number(window.view_batch.batch_record[window.houseArr.length + j].bird_catch);
                                    dateTotalBirdBalance = dateTotalBirdBalance + Number(window.view_batch.batch_record[window.houseArr.length + j].bird_balance);
                                }
                            }


                        } else{

                            console.log(window.view_batch.batch_record[i]);
                            if(window.view_batch.batch_record[i].bird_record_date == this.date){

                                if(weightEvent(this.date)){
                                    dateTotalBirdDeath = dateTotalBirdDeath + Number(window.view_batch.batch_record[i].bird_death);
                                    dateTotalBirdCull = dateTotalBirdCull + Number(window.view_batch.batch_record[i].bird_cull);
                                    dateTotalBirdCatch = dateTotalBirdCatch + Number(window.view_batch.batch_record[i].bird_catch);
                                    dateTotalBirdBalance = dateTotalBirdBalance + Number(window.view_batch.batch_record[i].bird_balance);
                                    dateTotalBirdWeight = dateTotalBirdWeight + Number(window.view_batch.batch_record[i].bird_weight); 
                                }else{
                                    dateTotalBirdDeath = dateTotalBirdDeath + Number(window.view_batch.batch_record[i].bird_death);
                                    dateTotalBirdCull = dateTotalBirdCull + Number(window.view_batch.batch_record[i].bird_cull);
                                    dateTotalBirdCatch = dateTotalBirdCatch + Number(window.view_batch.batch_record[i].bird_catch);
                                    dateTotalBirdBalance = dateTotalBirdBalance + Number(window.view_batch.batch_record[i].bird_balance);
                                }


                            }

                        }

                    }

                    console.log('xxxx',dateTotalBirdWeight,window.houseArr.length)
                    dateAverageBirdWeight = dateTotalBirdWeight / window.houseArr.length;

                    if(data){

                      if(accessLevel >= 3){
                        if(weightEvent(this.date)){
                            $(this.DOM).html('<div class="timelineContainer"><div class="content"><div style="display:flex;"><div><h2>'+this.dateObj.getDate()+'</h2></div><div style="padding-left:0.5rem;"><h6 style="line-height:12px;">'+window.monthNames[this.dateObj.getMonth()]+'</h6><h6 style="line-height:12px;">'+ window.dayName[this.dateObj.getDay()]+'</h6></div></div><div class="eventDiv" record_date="'+this.date+'"><h6>Project Initialized with '+data+' birds</h6><h6>Bird Balance: '+dateTotalBirdBalance+'</h6> <div class="row"> <div class="col-3 text-center"> <h6 style="margin: 0;">Death</h6> <h5>'+dateTotalBirdDeath+'</h5> </div> <div class="col-3 text-center"> <h6 style="margin: 0;">Cull</h6> <h5>'+dateTotalBirdCull+'</h5> </div> <div class="col-3 text-center text-center"> <h6 style="margin: 0;">Catch</h6> <h5>'+dateTotalBirdCatch+'</h5> </div> <div class="col-3 text-center"> <h6 style="margin: 0;">Weight</h6> <h5>'+dateAverageBirdWeight+'</h5> </div> </div><a href="#" class="batchEditRecordButton" record_date="'+this.date+'">Edit</a></div></div></div>');
                        }else{
                            $(this.DOM).html('<div class="timelineContainer"><div class="content"><div style="display:flex;"><div><h2>'+this.dateObj.getDate()+'</h2></div><div style="padding-left:0.5rem;"><h6 style="line-height:12px;">'+window.monthNames[this.dateObj.getMonth()]+'</h6><h6 style="line-height:12px;">'+ window.dayName[this.dateObj.getDay()]+'</h6></div></div><div class="eventDiv" record_date="'+this.date+'"><h6>Project Initialized with '+data+' birds</h6><h6>Bird Balance: '+dateTotalBirdBalance+'</h6> <div class="row"> <div class="col-4 text-center"> <h6 style="margin: 0;">Death</h6> <h5>'+dateTotalBirdDeath+'</h5> </div> <div class="col-4 text-center"> <h6 style="margin: 0;">Cull</h6> <h5>'+dateTotalBirdCull+'</h5> </div> <div class="col-4 text-center"> <h6 style="margin: 0;">Catch</h6> <h5>'+dateTotalBirdCatch+'</h5> </div> </div><a href="#" class="batchEditRecordButton" record_date="'+this.date+'">Edit</a></div></div></div>');
                        }
                      }else{
                        if(weightEvent(this.date)){
                            $(this.DOM).html('<div class="timelineContainer"><div class="content"><div style="display:flex;"><div><h2>'+this.dateObj.getDate()+'</h2></div><div style="padding-left:0.5rem;"><h6 style="line-height:12px;">'+window.monthNames[this.dateObj.getMonth()]+'</h6><h6 style="line-height:12px;">'+ window.dayName[this.dateObj.getDay()]+'</h6></div></div><div class="eventDiv" record_date="'+this.date+'"><h6>Project Initialized with '+data+' birds</h6><h6>Bird Balance: '+dateTotalBirdBalance+'</h6> <div class="row"> <div class="col-3 text-center"> <h6 style="margin: 0;">Death</h6> <h5>'+dateTotalBirdDeath+'</h5> </div> <div class="col-3 text-center"> <h6 style="margin: 0;">Cull</h6> <h5>'+dateTotalBirdCull+'</h5> </div> <div class="col-3 text-center"> <h6 style="margin: 0;">Catch</h6> <h5>'+dateTotalBirdCatch+'</h5> </div> <div class="col-3 text-center"> <h6 style="margin: 0;">Weight</h6> <h5>'+dateAverageBirdWeight+'</h5> </div> </div></div></div></div>');
                        }else{
                            $(this.DOM).html('<div class="timelineContainer"><div class="content"><div style="display:flex;"><div><h2>'+this.dateObj.getDate()+'</h2></div><div style="padding-left:0.5rem;"><h6 style="line-height:12px;">'+window.monthNames[this.dateObj.getMonth()]+'</h6><h6 style="line-height:12px;">'+ window.dayName[this.dateObj.getDay()]+'</h6></div></div><div class="eventDiv" record_date="'+this.date+'"><h6>Project Initialized with '+data+' birds</h6><h6>Bird Balance: '+dateTotalBirdBalance+'</h6> <div class="row"> <div class="col-4 text-center"> <h6 style="margin: 0;">Death</h6> <h5>'+dateTotalBirdDeath+'</h5> </div> <div class="col-4 text-center"> <h6 style="margin: 0;">Cull</h6> <h5>'+dateTotalBirdCull+'</h5> </div> <div class="col-4 text-center"> <h6 style="margin: 0;">Catch</h6> <h5>'+dateTotalBirdCatch+'</h5> </div> </div></div></div></div>');
                        }
                      }



                    }else{
                      if(accessLevel >= 3){
                        if(weightEvent(this.date)){
                            $(this.DOM).html('<div class="timelineContainer"><div class="content"><div style="display:flex;"><div><h2>'+this.dateObj.getDate()+'</h2></div><div style="padding-left:0.5rem;"><h6 style="line-height:12px;">'+window.monthNames[this.dateObj.getMonth()]+'</h6><h6 style="line-height:12px;">'+ window.dayName[this.dateObj.getDay()]+'</h6></div></div><div class="eventDiv" record_date="'+this.date+'"><h6>Bird Balance: '+dateTotalBirdBalance+'</h6> <div class="row"> <div class="col-3 text-center"> <h6 style="margin: 0;">Death</h6> <h5>'+dateTotalBirdDeath+'</h5> </div> <div class="col-3 text-center"> <h6 style="margin: 0;">Cull</h6> <h5>'+dateTotalBirdCull+'</h5> </div> <div class="col-3 text-center"> <h6 style="margin: 0;">Catch</h6> <h5>'+dateTotalBirdCatch+'</h5> </div> <div class="col-3 text-center"> <h6 style="margin: 0;">Weight</h6> <h5>'+dateAverageBirdWeight+'</h5> </div> </div><a href="#" class="batchEditRecordButton" record_date="'+this.date+'">Edit</a></div></div></div>');
                        }else{
                            $(this.DOM).html('<div class="timelineContainer"><div class="content"><div style="display:flex;"><div><h2>'+this.dateObj.getDate()+'</h2></div><div style="padding-left:0.5rem;"><h6 style="line-height:12px;">'+window.monthNames[this.dateObj.getMonth()]+'</h6><h6 style="line-height:12px;">'+ window.dayName[this.dateObj.getDay()]+'</h6></div></div><div class="eventDiv" record_date="'+this.date+'"><h6>Bird Balance: '+dateTotalBirdBalance+'</h6> <div class="row"> <div class="col-4 text-center"> <h6 style="margin: 0;">Death</h6> <h5>'+dateTotalBirdDeath+'</h5> </div> <div class="col-4 text-center"> <h6 style="margin: 0;">Cull</h6> <h5>'+dateTotalBirdCull+'</h5> </div> <div class="col-4 text-center"> <h6 style="margin: 0;">Catch</h6> <h5>'+dateTotalBirdCatch+'</h5> </div> </div><a href="#" class="batchEditRecordButton" record_date="'+this.date+'">Edit</a></div></div></div>');

                        }
                      }else{
                        if(weightEvent(this.date)){
                            $(this.DOM).html('<div class="timelineContainer"><div class="content"><div style="display:flex;"><div><h2>'+this.dateObj.getDate()+'</h2></div><div style="padding-left:0.5rem;"><h6 style="line-height:12px;">'+window.monthNames[this.dateObj.getMonth()]+'</h6><h6 style="line-height:12px;">'+ window.dayName[this.dateObj.getDay()]+'</h6></div></div><div class="eventDiv" record_date="'+this.date+'"><h6>Bird Balance: '+dateTotalBirdBalance+'</h6> <div class="row"> <div class="col-3 text-center"> <h6 style="margin: 0;">Death</h6> <h5>'+dateTotalBirdDeath+'</h5> </div> <div class="col-3 text-center"> <h6 style="margin: 0;">Cull</h6> <h5>'+dateTotalBirdCull+'</h5> </div> <div class="col-3 text-center"> <h6 style="margin: 0;">Catch</h6> <h5>'+dateTotalBirdCatch+'</h5> </div> <div class="col-3 text-center"> <h6 style="margin: 0;">Weight</h6> <h5>'+dateAverageBirdWeight+'</h5> </div> </div></div>');
                        }else{
                            $(this.DOM).html('<div class="timelineContainer"><div class="content"><div style="display:flex;"><div><h2>'+this.dateObj.getDate()+'</h2></div><div style="padding-left:0.5rem;"><h6 style="line-height:12px;">'+window.monthNames[this.dateObj.getMonth()]+'</h6><h6 style="line-height:12px;">'+ window.dayName[this.dateObj.getDay()]+'</h6></div></div><div class="eventDiv" record_date="'+this.date+'"><h6>Bird Balance: '+dateTotalBirdBalance+'</h6> <div class="row"> <div class="col-4 text-center"> <h6 style="margin: 0;">Death</h6> <h5>'+dateTotalBirdDeath+'</h5> </div> <div class="col-4 text-center"> <h6 style="margin: 0;">Cull</h6> <h5>'+dateTotalBirdCull+'</h5> </div> <div class="col-4 text-center"> <h6 style="margin: 0;">Catch</h6> <h5>'+dateTotalBirdCatch+'</h5> </div> </div></div></div></div>');

                        }
                      }

                    }


                    
                }




                break;

            case 'completed':


                    var dateTotalBirdDeath = 0;
                    var dateTotalBirdCull = 0;
                    var dateTotalBirdCatch = 0;
                    var dateTotalBirdBalance = 0;
                    var dateTotalBirdWeight = 0;
                    var dateAverageBirdWeight = 0;

                    // console.log(window.view_batch);
                    
                    for(var i=0;i<window.view_batch.batch_record.length;i++){



                        if(window.view_batch.batch_date == this.date){  ///if the timeline container we about to initialise it the first day
     
                            dateTotalBirdDeath = 0;
                            dateTotalBirdCull = 0;
                            dateTotalBirdCatch = 0;
                            dateTotalBirdBalance = 0;                           

                            if(weightEvent(this.date)){

                                dateTotalBirdWeight = 0;
                                dateAverageBirdWeight = 0;

                                for(var j= 0 ;j < window.houseArr.length;j++){      // we only ignore the first few records as it's initialisation record

                                    dateTotalBirdDeath = dateTotalBirdDeath + Number(window.view_batch.batch_record[window.houseArr.length + j].bird_death);
                                    dateTotalBirdCull = dateTotalBirdCull + Number(window.view_batch.batch_record[window.houseArr.length + j].bird_cull);
                                    dateTotalBirdCatch = dateTotalBirdCatch + Number(window.view_batch.batch_record[window.houseArr.length + j].bird_catch);
                                    dateTotalBirdBalance = dateTotalBirdBalance + Number(window.view_batch.batch_record[window.houseArr.length + j].bird_balance);
                                    dateTotalBirdWeight = dateTotalBirdWeight + Number(window.view_batch.batch_record[window.houseArr.length + j].bird_weight);
                                    console.log('weight',window.view_batch.batch_record[window.houseArr.length + j])
                                }

                                dateAverageBirdWeight = dateTotalBirdWeight / window.houseArr.length;

                            }else{
                                for(var j= 0 ;j < window.houseArr.length;j++){      // we only ignore the first few records as it's initialisation record

                                    dateTotalBirdDeath = dateTotalBirdDeath + Number(window.view_batch.batch_record[window.houseArr.length + j].bird_death);
                                    dateTotalBirdCull = dateTotalBirdCull + Number(window.view_batch.batch_record[window.houseArr.length + j].bird_cull);
                                    dateTotalBirdCatch = dateTotalBirdCatch + Number(window.view_batch.batch_record[window.houseArr.length + j].bird_catch);
                                    dateTotalBirdBalance = dateTotalBirdBalance + Number(window.view_batch.batch_record[window.houseArr.length + j].bird_balance);
                                }
                            }


                        } else{

                            console.log(window.view_batch.batch_record[i]);
                            if(window.view_batch.batch_record[i].bird_record_date == this.date){

                                if(weightEvent(this.date)){
                                    dateTotalBirdDeath = dateTotalBirdDeath + Number(window.view_batch.batch_record[i].bird_death);
                                    dateTotalBirdCull = dateTotalBirdCull + Number(window.view_batch.batch_record[i].bird_cull);
                                    dateTotalBirdCatch = dateTotalBirdCatch + Number(window.view_batch.batch_record[i].bird_catch);
                                    dateTotalBirdBalance = dateTotalBirdBalance + Number(window.view_batch.batch_record[i].bird_balance);
                                    dateTotalBirdWeight = dateTotalBirdWeight + Number(window.view_batch.batch_record[i].bird_weight); 
                                }else{
                                    dateTotalBirdDeath = dateTotalBirdDeath + Number(window.view_batch.batch_record[i].bird_death);
                                    dateTotalBirdCull = dateTotalBirdCull + Number(window.view_batch.batch_record[i].bird_cull);
                                    dateTotalBirdCatch = dateTotalBirdCatch + Number(window.view_batch.batch_record[i].bird_catch);
                                    dateTotalBirdBalance = dateTotalBirdBalance + Number(window.view_batch.batch_record[i].bird_balance);
                                }


                            }

                        }

                    }


                    dateAverageBirdWeight = dateTotalBirdWeight / window.houseArr.length;

                    if(data){

                        if(weightEvent(this.date)){
                            $(this.DOM).html('<div class="timelineContainer"><div class="content"><div style="display:flex;"><div><h2>'+this.dateObj.getDate()+'</h2></div><div style="padding-left:0.5rem;"><h6 style="line-height:12px;">'+window.monthNames[this.dateObj.getMonth()]+'</h6><h6 style="line-height:12px;">'+ window.dayName[this.dateObj.getDay()]+'</h6></div></div><div class="eventDiv" record_date="'+this.date+'"><h6>Project Initialized with '+data+' birds</h6><h6>Bird Balance: '+dateTotalBirdBalance+'</h6> <div class="row"> <div class="col-3 text-center"> <h6 style="margin: 0;">Death</h6> <h5>'+dateTotalBirdDeath+'</h5> </div> <div class="col-3 text-center"> <h6 style="margin: 0;">Cull</h6> <h5>'+dateTotalBirdCull+'</h5> </div> <div class="col-3 text-center"> <h6 style="margin: 0;">Catch</h6> <h5>'+dateTotalBirdCatch+'</h5> </div> <div class="col-3 text-center"> <h6 style="margin: 0;">Weight</h6> <h5>'+dateAverageBirdWeight+'</h5> </div> </div></div></div></div>');
                        }else{
                            $(this.DOM).html('<div class="timelineContainer"><div class="content"><div style="display:flex;"><div><h2>'+this.dateObj.getDate()+'</h2></div><div style="padding-left:0.5rem;"><h6 style="line-height:12px;">'+window.monthNames[this.dateObj.getMonth()]+'</h6><h6 style="line-height:12px;">'+ window.dayName[this.dateObj.getDay()]+'</h6></div></div><div class="eventDiv" record_date="'+this.date+'"><h6>Project Initialized with '+data+' birds</h6><h6>Bird Balance: '+dateTotalBirdBalance+'</h6> <div class="row"> <div class="col-4 text-center"> <h6 style="margin: 0;">Death</h6> <h5>'+dateTotalBirdDeath+'</h5> </div> <div class="col-4 text-center"> <h6 style="margin: 0;">Cull</h6> <h5>'+dateTotalBirdCull+'</h5> </div> <div class="col-4 text-center"> <h6 style="margin: 0;">Catch</h6> <h5>'+dateTotalBirdCatch+'</h5> </div> </div></div></div></div>');
                        }


                    }else{
                        if(weightEvent(this.date)){
                            $(this.DOM).html('<div class="timelineContainer"><div class="content"><div style="display:flex;"><div><h2>'+this.dateObj.getDate()+'</h2></div><div style="padding-left:0.5rem;"><h6 style="line-height:12px;">'+window.monthNames[this.dateObj.getMonth()]+'</h6><h6 style="line-height:12px;">'+ window.dayName[this.dateObj.getDay()]+'</h6></div></div><div class="eventDiv" record_date="'+this.date+'"><h6>Bird Balance: '+dateTotalBirdBalance+'</h6> <div class="row"> <div class="col-3 text-center"> <h6 style="margin: 0;">Death</h6> <h5>'+dateTotalBirdDeath+'</h5> </div> <div class="col-3 text-center"> <h6 style="margin: 0;">Cull</h6> <h5>'+dateTotalBirdCull+'</h5> </div> <div class="col-3 text-center"> <h6 style="margin: 0;">Catch</h6> <h5>'+dateTotalBirdCatch+'</h5> </div> <div class="col-3 text-center"> <h6 style="margin: 0;">Weight</h6> <h5>'+dateAverageBirdWeight+'</h5> </div> </div></div></div></div>');
                        }else{
                            $(this.DOM).html('<div class="timelineContainer"><div class="content"><div style="display:flex;"><div><h2>'+this.dateObj.getDate()+'</h2></div><div style="padding-left:0.5rem;"><h6 style="line-height:12px;">'+window.monthNames[this.dateObj.getMonth()]+'</h6><h6 style="line-height:12px;">'+ window.dayName[this.dateObj.getDay()]+'</h6></div></div><div class="eventDiv" record_date="'+this.date+'"><h6>Bird Balance: '+dateTotalBirdBalance+'</h6> <div class="row"> <div class="col-4 text-center"> <h6 style="margin: 0;">Death</h6> <h5>'+dateTotalBirdDeath+'</h5> </div> <div class="col-4 text-center"> <h6 style="margin: 0;">Cull</h6> <h5>'+dateTotalBirdCull+'</h5> </div> <div class="col-4 text-center"> <h6 style="margin: 0;">Catch</h6> <h5>'+dateTotalBirdCatch+'</h5> </div> </div></div></div></div>');

                        }

                    }


                    
                
              break;



        }




    }



  }
}

var timelineArr = [];
var recordedDateArr = [];

var dateArr = [];

for(var i=0;i<window.view_batch.batch_record.length;i++){
    if(recordedDateArr.indexOf(window.view_batch.batch_record[i].bird_record_date) == -1){
        recordedDateArr.push(window.view_batch.batch_record[i].bird_record_date);
    }
}

var date1 = new Date(Date.now());
var date2 = new Date(window.view_batch.batch_date);
var timeDiff = Math.abs(date2.getTime() - date1.getTime());
var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
var totalDays = diffDays;

if(totalDays <1){
  totalDays = 1;
}


for(var i=0;i<totalDays;i++){
    var tomorrow = new Date(window.view_batch.batch_date);
    tomorrow.setDate(new Date(window.view_batch.batch_date).getDate()+i);
    dateArr.push(tomorrow);
}

console.log(recordedDateArr);

for(var i=0;i<dateArr.length;i++){
    console.log(formatDate(dateArr[i]));
    if(recordedDateArr.indexOf(formatDate(dateArr[i])) == -1){
        var newTimelineContainer = new timelineContainer(formatDate(dateArr[i]),'pending');        
    }else{
        var newTimelineContainer = new timelineContainer(formatDate(dateArr[i]),'recorded');
    }

    timelineArr.push(newTimelineContainer);

}





var batchStatus = getCategoryDesc('batch_status',window.view_batch.batch_status);

switch(batchStatus){

    case 'initialized':
        timelineArr[0].generateDOM('initialize',totalInitBird);
        updateTimeline();
        break;

    case 'active':
        for(var i=0;i<dateArr.length;i++){
            if(i == 0){
                timelineArr[i].generateDOM('active',totalInitBird);
            }else{
                timelineArr[i].generateDOM('active');
            }
            
        }
        updateTimeline();
        break;

    case 'completed':
        for(var i=0;i<recordedDateArr.length;i++){
            if(i == 0){
                timelineArr[i].generateDOM('completed',totalInitBird);
            }else{
                timelineArr[i].generateDOM('completed');
            }
            
        }

        $('#addEventButton').remove();
        $('.stopBatch').remove();


        updateTimeline();
        break;



}


function updateTimeline(){

    $('.timeline').empty();

    for(var i=(timelineArr.length - 1);i>=0;i--){
        $('.timeline').append(timelineArr[i].DOM);
    }

    for(var i=0;i<window.view_batch.batch_event.length;i++){            ///insert the event line into the timeline container
        var eventType = window.view_batch.batch_event[i].event_type;
        eventType = getCategoryDesc('event',eventType);

        var eventState = window.view_batch.batch_event[i].event_state;

        switch(eventType){

            case 'weight':
                if(eventState == '1'){
                    $('.eventDiv[record_date="'+window.view_batch.batch_event[i].event_date+'"]').append('<div class="timelineEvent pending"> <h6 style="margin:0;">Weight Measure</h6> </div>');
                }
                if(eventState == '0'){
                    $('.eventDiv[record_date="'+window.view_batch.batch_event[i].event_date+'"]').append('<div class="timelineEvent completed"> <h6 style="margin:0;">Weight Measure</h6> </div>');
                }
                break;

        }



    }

    $('.timelineContainer').removeClass('left');
    $('.timelineContainer').removeClass('right');

    for(var i=0;i<$('.timelineContainer').length;i++){

        var currentContainer = $('.timelineContainer')[i];
        if(i%2 == 0){
          $($('.timelineContainer')[i]).addClass('left');
        } else{
          $($('.timelineContainer')[i]).addClass('right');
        }

    }

    $($('.timelineContainer')[$('.timelineContainer').length - 1]).css('margin','0 0 4rem 0');



}



///////record functions

var stockSelect = document.createElement('SELECT');
$(stockSelect).attr('class','form-control');

for(var i=0;i<window._dashboard.farm_list[window.view_batch.batch_farm_id].stock_list.length;i++){

    $(stockSelect).append('<option value="'+window._dashboard.farm_list[window.view_batch.batch_farm_id].stock_list[i].stock_id+'">'+window._dashboard.farm_list[window.view_batch.batch_farm_id].stock_list[i].stock_name+'</option>');
}

var feedInput = document.createElement('DIV');
$(feedInput).attr('class','row');

for(var i=0;i<window.category.length;i++){
    if(window.category[i].category_level == 'feed'){
        var newFeedInput = '<div class="row feed_input" style="width:100%;" feed_id="'+window.category[i].category_id+'"><div class="col-12"> <h6 style="margin: 0;">'+window.category[i].category_desc+'</h6> </div> <div class="col-4 text-center"> <div class="form-group"> <input class="form-control feed_quantity" type="number" min="0" step="0.01" required> </div> </div> <div class="col-8"> <select class="form-control feed_stock_input"> '+ $(stockSelect).html() +' </select> </div></div>';
        $(feedInput).append(newFeedInput);
    }
}



$(document).on('click','.batchAddRecordButton',function(){

    $('#batchRecord').empty();
    $('.addProjectRecordDisplayDate').text('Date: '+ $(this).attr('record_date'));

    var recordDate = $(this).attr('record_date');

    for(var i=0;i<window.houseArr.length;i++){

      for(var j=0;j<window.view_batch.batch_house_balance.length;j++){
        if(window.view_batch.batch_house_balance[j].house == window.houseArr[i].house_id){
          var houseBalance = Number(window.view_batch.batch_house_balance[j].balance);
          break;
        }
      }

        console.log(window.houseArr);

        if(weightEvent(recordDate)){
            $('#batchRecord').append('<div class="col-sm-12 col-md-8"> <div class="card recordCard" house_id="'+window.houseArr[i].house_id+'" house_balance= "'+houseBalance+'"> <div class="card-body"> <h5 class="card-title">'+window.houseArr[i].house_name+'</h5> <h6>House Balance: '+houseBalance+'</h6> <div class="row" style="width: 100%;margin: 0;"> <div class="col-3 text-center" style="display: flex;flex-direction: column;justify-content: center;align-items: center;padding:0 0.5rem;"> <p style="margin: 0;">Death</p> <div class="form-group"> <input class="form-control bird_death_input" type="number" min="0" required name=""> </div> </div> <div class="col-3 text-center" style="display: flex;flex-direction: column;justify-content: center;align-items: center;padding:0 0.5rem;"> <p style="margin: 0;">Cull</p> <div class="form-group"> <input class="form-control bird_cull_input" type="number" min="0" required name=""> </div> </div> <div class="col-3 text-center" style="display: flex;flex-direction: column;justify-content: center;align-items: center;padding:0 0.5rem;"> <p style="margin: 0;">Catch</p> <div class="form-group"> <input class="form-control bird_catch_input profitTrigger" type="number" min="0" required name=""> </div> </div> <div class="col-3 text-center" style="display: flex;flex-direction: column;justify-content: center;align-items: center;padding:0 0.5rem;"> <p style="margin: 0;">Weight</p> <div class="form-group"> <input class="form-control bird_weight_input profitTrigger" type="text" name=""> </div> </div>  </div> </div><div class="row" style="padding:0.5rem;width:100%;">'+$(feedInput).html()+'</div> </div> </div>');

        }else{
            $('#batchRecord').append('<div class="col-sm-12 col-md-8"> <div class="card recordCard" house_id="'+window.houseArr[i].house_id+'"  house_balance= "'+houseBalance+'"> <div class="card-body"> <h5 class="card-title">'+window.houseArr[i].house_name+'</h5> <h6>House Balance: '+houseBalance+'</h6> <div class="row" style="width: 100%;margin: 0;"> <div class="col-4 text-center" style="display: flex;flex-direction: column;justify-content: center;align-items: center;"> <p style="margin: 0;">Death</p> <div class="form-group"> <input class="form-control bird_death_input" type="number" min="0" required name=""> </div> </div> <div class="col-4 text-center" style="display: flex;flex-direction: column;justify-content: center;align-items: center;"> <p style="margin: 0;">Cull</p> <div class="form-group"> <input class="form-control bird_cull_input" type="number" min="0" required name=""> </div> </div> <div class="col-4 text-center" style="display: flex;flex-direction: column;justify-content: center;align-items: center;"> <p style="margin: 0;">Catch</p>  <div class="form-group" data-toggle="tooltip" title="Catch is only available if weight is measured."> <input class="form-control bird_catch_input" type="number" min="0" required name="" value="0" > </div> </div> </div> </div><div class="row" style="padding:0.5rem;width:100%;">'+$(feedInput).html()+'</div> </div> </div>');
        }

    }

    $('#addBatchRecord').modal('show');
    $('#addBatchRecordForm').find('input').removeAttr('disabled');
    $('#addBatchRecordForm').find('textarea').removeAttr('disabled');
    $('#addBatchRecordForm').find('select').removeAttr('disabled');
    $('#addBatchRecordConfirm').removeAttr('disabled');
    $('#addBatchRecordConfirm').html('Add');
    $('#addBatchRecordConfirm').attr('record_date', $(this).attr('record_date'));
    $('#addBatchRecordConfirm').attr('operation', 'insert');

    $('#catchProfitDisplay').empty();

    if(!weightEvent(recordDate)){
      $('.bird_catch_input').attr('disabled','true'); 
      $('[data-toggle="tooltip"]').tooltip();
    }

});

$(document).on('click','#addBatchRecordConfirm',function(){

  var operation = $(this).attr('operation');

  var limitExceed = false;
  var exceedHouse = 0;
  var instance = $('#addBatchRecordForm').parsley({
              errorClass: 'is-invalid',
              successClass: 'is-valid',
              errorsWrapper: '',
              errorTemplate: '',
              trigger: 'change'
          });

  switch(operation){

    case 'insert':

      for(var i=0;i<$('.recordCard').length;i++){
        var houseBalance = $($('.recordCard')[i]).attr('house_balance');
        var birdDeath  = Number($($('.recordCard')[i]).find('.bird_death_input').val());
        var birdCull  = Number($($('.recordCard')[i]).find('.bird_cull_input').val());
        var birdCatch  = Number($($('.recordCard')[i]).find('.bird_catch_input').val());

        if((birdDeath + birdCull + birdCatch) > houseBalance){
          limitExceed = true;
          exceedHouse = i;
          break;
        }
      }

      for(var i=0;i<$('.feed_input').length;i++){

        var stockId = $($('.feed_input')[i]).find('.feed_stock_input').val();
        var feedId = $($('.feed_input')[i]).attr('feed_id');

        for(var j=0;j<window._dashboard.farm_list[window.view_batch.batch_farm_id].stock_list.length;j++){
          var currentStock = window._dashboard.farm_list[window.view_batch.batch_farm_id].stock_list[j];
          if(currentStock.stock_id == stockId){
            var stockBalance = currentStock.stock_balance;
            for(var k=0;k<stockBalance.length;k++){
              if(stockBalance[k].sb_item == feedId){
                $('.feed_input[feed_id="'+feedId+'"]').find('.feed_quantity').attr('max',stockBalance[k].sb_balance);
                break;
              }
            }
          }

        }
      }


      break;

    case 'edit':

      for(var i=0;i<$('.recordCard').length;i++){
        var houseBalance = $($('.recordCard')[i]).attr('house_balance');
        var birdDeath  = Number($($('.recordCard')[i]).find('.bird_death_input').val());
        var birdCull  = Number($($('.recordCard')[i]).find('.bird_cull_input').val());
        var birdCatch  = Number($($('.recordCard')[i]).find('.bird_catch_input').val());

        for(var j=0;j<window.view_batch.batch_record.length;j++){
          if(window.view_batch.batch_record[j].bird_record_date == $($('.recordCard')[i]).attr('record_date') && 
              window.view_batch.batch_record[j].bird_house_id == $($('.recordCard')[i]).attr('house_id')){


              houseBalance = Number(window.view_batch.batch_record[i].bird_death) + Number(window.view_batch.batch_record[i].bird_cull) + Number(window.view_batch.batch_record[i].bird_cull);


          }
        }

        if((birdDeath + birdCull + birdCatch) > houseBalance){
          limitExceed = true;
          exceedHouse = i;

        break;



        }
      }









      break;


  }



  console.log(limitExceed);

  if(limitExceed){
    $($('.recordCard')[exceedHouse]).find('.bird_death_input').addClass('is-invalid');
    $($('.recordCard')[exceedHouse]).find('.bird_cull_input').addClass('is-invalid');
    $($('.recordCard')[exceedHouse]).find('.bird_catch_input').addClass('is-invalid');
  }else{
    instance.validate();
    if(instance.isValid() && !limitExceed){

      switch(operation){

          case 'insert':
              var recordArr = [];
              var stockRecordObj = {};

              for(var i=0;i<window._dashboard.farm_list[window.view_batch.batch_farm_id].stock_list.length;i++){
                var tmpFeed = {};
                for(var j=0;j<window.category.length;j++){            
                    if(window.category[j].category_level == 'feed'){
                        tmpFeed[window.category[j].category_id] = 0;
                    }
                }
                stockRecordObj[window._dashboard.farm_list[window.view_batch.batch_farm_id].stock_list[i].stock_id] = tmpFeed;
              }



              for(var i=0;i<$('.recordCard').length;i++){        

                var feedArr = [];
                var curHouseId = $($('.recordCard')[i]).attr('house_id');

                for(var j=0;j<$($('.recordCard')[i]).find('.feed_input').length;j++){

                    var newFeedData ={
                        operation: 'insert',
                        feed_id : $($($('.recordCard')[i]).find('.feed_input')[j]).attr('feed_id'),
                        feed_quantity: $($($('.recordCard')[i]).find('.feed_input')[j]).find('.feed_quantity').val(),
                        feed_stock_id: $($($('.recordCard')[i]).find('.feed_input')[j]).find('.feed_stock_input').val(),
                        feed_type: getCategoryCode('record_type','feeding'),
                        feed_house_id: curHouseId
                    }

                    feedArr.push(newFeedData);

                    var feedStockId = $($($('.recordCard')[i]).find('.feed_input')[j]).find('.feed_stock_input').val();
                    var feedId = $($($('.recordCard')[i]).find('.feed_input')[j]).attr('feed_id');

                    stockRecordObj[feedStockId][feedId] = Number(stockRecordObj[feedStockId][feedId]) + Number($($($('.recordCard')[i]).find('.feed_input')[j]).find('.feed_quantity').val());

                }

                

                if($($('.recordCard')[i]).find('.bird_death_input').val() > 0){
                    var bird_death = $($('.recordCard')[i]).find('.bird_death_input').val();
                }else{
                     var bird_death = 0;
                }

                if($($('.recordCard')[i]).find('.bird_cull_input').val() > 0){
                    var bird_cull = $($('.recordCard')[i]).find('.bird_cull_input').val();
                }else{
                     var bird_cull = 0;
                }

                if($($('.recordCard')[i]).find('.bird_catch_input').val() > 0){
                    var bird_catch = $($('.recordCard')[i]).find('.bird_catch_input').val();
                }else{
                     var bird_catch = 0;
                }

                for(var j = (window.view_batch.batch_record.length - 1);j>= 0 ;j--){
                    if($($('.recordCard')[i]).attr('house_id') == window.view_batch.batch_record[j].bird_house_id){
                        var bird_balance = Number(window.view_batch.batch_record[j].bird_balance);
                        break;
                    }
                }

                for(var j=0; j<window._dashboard.farm_list[window.view_batch.batch_farm_id].house_list.length;j++){
                    if($($('.recordCard')[i]).attr('house_id') == window._dashboard.farm_list[window.view_batch.batch_farm_id].house_list[j].house_id){
                        var usedCapacity = Number(window._dashboard.farm_list[window.view_batch.batch_farm_id].house_list[j].house_used_capacity);
                        break;
                    }
                }

                bird_balance = bird_balance - ( Number(bird_death) + Number(bird_cull) + Number(bird_catch));
                usedCapacity = usedCapacity - ( Number(bird_death) + Number(bird_cull) + Number(bird_catch));

                if(weightEvent($(this).attr('record_date'))){

                  if($($('.recordCard')[i]).find('.bird_weight_input').val() > 0){
                      var bird_weight = $($('.recordCard')[i]).find('.bird_weight_input').val();
                  }else{
                      var bird_weight = 0;
                  }

                  for(var j=0;j<window.category.length;j++){
                    if(window.category[j].category_code == window.view_batch.batch_type && window.category[j].category_level == 'batch_price'){
                      var price = Number(window.category[j].category_desc);
                    }
                  }

                  var bird_profit = (Number(bird_catch) * Number(bird_weight)) * price;

                  var birdRecord ={
                        operation: 'insert',
                        house_id : $($('.recordCard')[i]).attr('house_id'),
                        bird_death : bird_death,
                        bird_cull : bird_cull,
                        bird_catch : bird_catch,
                        bird_balance: bird_balance,
                        bird_weight: bird_weight,
                        bird_batch_uid: window.view_batch.batch_uid,
                        bird_profit: bird_profit,
                        bird_price: price
                    }


                }else{
                    var birdRecord ={
                        operation: 'insert',
                        house_id : $($('.recordCard')[i]).attr('house_id'),
                        bird_death : bird_death,
                        bird_cull : bird_cull,
                        bird_catch : bird_catch,
                        bird_balance: bird_balance,
                        bird_batch_uid: window.view_batch.batch_uid,
                    }
                }


                var houseRecord = {
                    operation: 'update',
                    house_id : $($('.recordCard')[i]).attr('house_id'),
                    house_used_capacity: usedCapacity
                }

                var recordObj = {
                    bird_record: birdRecord,
                    feed_record: feedArr,
                    house_record: houseRecord
                }

                recordArr.push(recordObj);
              }

              var newStockArr = [];

              for(var obj in stockRecordObj){

                for(var itemId in stockRecordObj[obj]){

                    var currentBalance = 0;

                    for(var i=0;i<window._dashboard.farm_list[window.view_batch.batch_farm_id].stock_list.length;i++){
                         console.log(window._dashboard.farm_list[window.view_batch.batch_farm_id].stock_list[i].stock_id);
                        if(window._dashboard.farm_list[window.view_batch.batch_farm_id].stock_list[i].stock_id == obj){
                            for(var j = 0; j<window._dashboard.farm_list[window.view_batch.batch_farm_id].stock_list[i].stock_balance.length;j++){
                                if(window._dashboard.farm_list[window.view_batch.batch_farm_id].stock_list[i].stock_balance[j].sb_item == itemId){
                                    currentBalance = window._dashboard.farm_list[window.view_batch.batch_farm_id].stock_list[i].stock_balance[j].sb_balance;
                                }
                            }
                            
                        }
                    }

                    var newBalance = Number(currentBalance) - Number(stockRecordObj[obj][itemId]);

                    var newStockObj = {

                        sb_stock_id : obj,
                        sb_item: itemId,
                        sb_balance: newBalance

                    }

                    newStockArr.push(newStockObj);

                }
              }



              $('#addBatchRecordForm').find('input').attr('disabled','true');
              $('#addBatchRecordForm').find('textarea').attr('disabled','true');
              $('#addBatchRecordForm').find('select').attr('disabled','true');

              $('#addBatchRecordConfirm').attr('disabled','true');
              $('#addBatchRecordConfirm').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>')

              var payload = {

                batch_uid: window.view_batch.batch_uid,
                record: recordArr,
                stock: newStockArr,
                status: getCategoryDesc('batch_status',window.view_batch.batch_status),
                date: $(this).attr('record_date')
              }

              console.log(payload);

              $.ajax({
                url: 'assets/php/batchAddRecord.php',
                type: 'POST',
                data: payload,
                success: function(data){
                    $('#addBatchRecord').modal('hide');
                    $('.detailBackground').click();
                    farmerReset(window.view_batch.batch_uid);
                    window._dashboard.generateDashboard();
                    console.log(data);
                }
              });     


              break;

          case 'edit':

              var recordArr = [];
              var feedArr = [];
              var stockRecordObj = {};
              var updateStock = window._dashboard.farm_list[window.view_batch.batch_farm_id].stock_list;

              for(var i=0;i<window._dashboard.farm_list[window.view_batch.batch_farm_id].stock_list.length;i++){ ///prepare the total
                var tmpFeed = {};
                for(var j=0;j<window.category.length;j++){            
                    if(window.category[j].category_level == 'feed'){
                        tmpFeed[window.category[j].category_id] = 0;
                    }
                }
                stockRecordObj[window._dashboard.farm_list[window.view_batch.batch_farm_id].stock_list[i].stock_id] = tmpFeed;
              }

              for(var i=0;i<$('.recordCard').length;i++){

                  var recordCardHouseId = $($('.recordCard')[i]).attr('house_id');
                  var recordCardDate = $(this).attr('record_date');
                  
                  /// get the value for each bird data 

                  if($($('.recordCard')[i]).find('.bird_death_input').val() > 0){
                    var current_bird_death = $($('.recordCard')[i]).find('.bird_death_input').val();
                  }else{
                     var current_bird_death = 0;
                  }

                  if($($('.recordCard')[i]).find('.bird_cull_input').val() > 0){
                    var current_bird_cull = $($('.recordCard')[i]).find('.bird_cull_input').val();
                  }else{
                     var current_bird_cull = 0;
                  }

                  if($($('.recordCard')[i]).find('.bird_catch_input').val() > 0){
                    var current_bird_catch = $($('.recordCard')[i]).find('.bird_catch_input').val();
                  }else{
                     var current_bird_catch = 0;
                  }

                  var recordExist = false;


                  for(var j=window.houseArr.length;j<window.view_batch.batch_record.length;j++){

                      if((window.view_batch.batch_record[j].bird_record_date == recordCardDate) && (window.view_batch.batch_record[j].bird_house_id == recordCardHouseId)){       ///record exist where house id and date id is in record array

                      for(var k=0; k<window._dashboard.farm_list[window.view_batch.batch_farm_id].house_list.length;k++){
                          if(recordCardHouseId == window._dashboard.farm_list[window.view_batch.batch_farm_id].house_list[k].house_id){
                              var oldUsedCapacity = Number(window._dashboard.farm_list[window.view_batch.batch_farm_id].house_list[k].house_used_capacity);
                              break;
                          }
                      }

                        var oldBirdBalance = Number(window.view_batch.batch_record[j].bird_balance);
                        var oldBirdLost = Number(window.view_batch.batch_record[j].bird_death) + Number(window.view_batch.batch_record[j].bird_cull) + Number(window.view_batch.batch_record[j].bird_catch);
                        var bird_balance = oldBirdBalance + oldBirdLost - (Number(current_bird_death) + Number(current_bird_catch) + Number(current_bird_cull));
                        var usedCapacity = (oldUsedCapacity + oldBirdLost) - (Number(current_bird_death) + Number(current_bird_catch) + Number(current_bird_cull));

                        if(weightEvent($(this).attr('record_date'))){

                          for(var k=0;k<$($('.recordCard')[i]).find('.bird_weight_input').length;k++){

                            if($($($('.recordCard')[i]).find('.bird_weight_input')[k]).val() > 0){
                                var bird_weight = $($($('.recordCard')[i]).find('.bird_weight_input')[k]).val();
                            }else{
                                var bird_weight = 0;
                            }

                            var price = $('.profitTriggerEdit').attr('bird_price');

                            var bird_profit = (Number(current_bird_catch) * Number(bird_weight)) * price;

                            var birdRecord = {
                                  operation: 'edit',
                                  bird_id: window.view_batch.batch_record[j].bird_id,
                                  house_id : recordCardHouseId,
                                  bird_death : current_bird_death,
                                  bird_cull : current_bird_cull,
                                  bird_catch : current_bird_catch,
                                  bird_balance: bird_balance,
                                  bird_weight: bird_weight,
                                  bird_batch_uid: window.view_batch.batch_uid,
                                  bird_price : price,
                                  bird_profit : bird_profit 
                            }

                          }



                        }else{
                            var birdRecord = {
                                operation: 'edit',
                                bird_id: window.view_batch.batch_record[j].bird_id,
                                house_id : recordCardHouseId,
                                bird_death : current_bird_death,
                                bird_cull : current_bird_cull,
                                bird_catch : current_bird_catch,
                                bird_balance: bird_balance,
                                bird_batch_uid: window.view_batch.batch_uid,
                            }

                        }


                        var houseRecord = {
                            operation: 'update',
                            house_id : recordCardHouseId,
                            house_used_capacity: usedCapacity
                        }

                                          

                        for(var k=0;k<$($('.recordCard')[i]).find('.feed_input').length;k++){
                          var stockRecordExist = false;
                          var current_sr_id = $($($('.recordCard')[i]).find('.feed_input')[k]).find('.feed_quantity').attr('sr_id');
                          for(var l=0;l<window.view_batch.batch_stock_record.length;l++){
                            if(current_sr_id == window.view_batch.batch_stock_record[l].sr_id){

                              var oldStockId = window.view_batch.batch_stock_record[l].sr_stock;
                              var oldStockItem = window.view_batch.batch_stock_record[l].sr_item;
                              var oldStockQuantity = window.view_batch.batch_stock_record[l].sr_item_quantity;

                              var newStockId = $($($('.recordCard')[i]).find('.feed_input')[k]).find('.feed_stock_input').val();
                              var newStockItem = $($($('.recordCard')[i]).find('.feed_input')[k]).attr('feed_id');
                              var newStockQuantity = $($($('.recordCard')[i]).find('.feed_input')[k]).find('.feed_quantity').val();

                              var newFeedData ={
                                  operation: 'edit',
                                  feed_id : newStockItem,
                                  feed_sr_id :current_sr_id,
                                  feed_quantity: newStockQuantity,
                                  feed_stock_id: newStockId,
                                  feed_type: getCategoryCode('record_type','feeding'),
                                  feed_house_id: recordCardHouseId
                              }                            

                              for(var m=0;m<updateStock.length;m++){

                                if(oldStockId == updateStock[m].stock_id){
                                  for(var n=0;n<updateStock[m].stock_balance.length;n++){
                                    if(updateStock[m].stock_balance[n].sb_item == oldStockItem){
                                      updateStock[m].stock_balance[n].sb_balance = Number(updateStock[m].stock_balance[n].sb_balance) + Number(oldStockQuantity);
                                    }
                                  }
                                }


                                if(newStockId == updateStock[m].stock_id){
                                  for(var n=0;n<updateStock[m].stock_balance.length;n++){
                                    if(updateStock[m].stock_balance[n].sb_item == newStockItem){
                                      updateStock[m].stock_balance[n].sb_balance = Number(updateStock[m].stock_balance[n].sb_balance) - Number(newStockQuantity);
                                    }
                                  }
                                }


                              }

                              stockRecordExist = true;
                              break;
                            }



                          }

                          if(!stockRecordExist){
                             var newFeedData ={
                                  operation: 'insert',
                                  feed_id : $($($('.recordCard')[i]).find('.feed_input')[k]).attr('feed_id'),
                                  feed_quantity: $($($('.recordCard')[i]).find('.feed_input')[k]).find('.feed_quantity').val(),
                                  feed_stock_id: $($($('.recordCard')[i]).find('.feed_input')[k]).find('.feed_stock_input').val(),
                                  feed_type: getCategoryCode('record_type','feeding'),
                                  feed_house_id: recordCardHouseId
                              }
                          }

                          feedArr.push(newFeedData);

                          


                        }


                        recordExist = true;

                        var recordObj = {
                            bird_record: birdRecord,
                            feed_record: feedArr,
                            house_record: houseRecord
                        }

                        recordArr.push(recordObj);
                        break;


                      }



                  }


              }

              var stockArr = [];

              for(var o=0;o<updateStock.length;o++){
                for(var p=0; p<updateStock[o].stock_balance.length;p++){
                  var newStockObj = {
                    sb_stock_id: updateStock[o].stock_id,
                    sb_item: updateStock[o].stock_balance[p].sb_item,
                    sb_balance: updateStock[o].stock_balance[p].sb_balance
                  }

                  stockArr.push(newStockObj);

                }
              }



              var payload = {

                batch_uid: window.view_batch.batch_uid,
                record: recordArr,
                stock: stockArr,
                date: $(this).attr('record_date')
              }

              $('#addBatchRecordForm').find('input').attr('disabled','true');
              $('#addBatchRecordForm').find('textarea').attr('disabled','true');
              $('#addBatchRecordForm').find('select').attr('disabled','true');

              $('#addBatchRecordConfirm').attr('disabled','true');
              $('#addBatchRecordConfirm').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>')

              $.ajax({
                url: 'assets/php/batchAddRecord.php',
                type: 'POST',
                data: payload,
                success: function(data){
                    $('#addBatchRecord').modal('hide');
                    $('.detailBackground').click();
                    window._dashboard.generateDashboard();
                    console.log(data);
                }
              });   

              console.log(payload);


              break;


      }


    }
  }


})

$(document).on('click','.batchEditRecordButton',function(){

    $('#batchRecord').empty();
    $('.addProjectRecordDisplayDate').text('Date: '+ $(this).attr('record_date'));


    if(weightEvent($(this).attr('record_date'))){
        for(var i=0;i<window.houseArr.length;i++){

          for(var j=0;j<window.view_batch.batch_house_balance.length;j++){
            if(window.view_batch.batch_house_balance[j].house == window.houseArr[i].house_id){
              var houseBalance = Number(window.view_batch.batch_house_balance[j].balance);
              break;
            }
          }


            $('#batchRecord').append('<div class="col-sm-12 col-md-8"> <div class="card recordCard" house_id="'+window.houseArr[i].house_id+'"  house_balance= "'+houseBalance+'"> <div class="card-body"> <h5 class="card-title">'+window.houseArr[i].house_name+'</h5> <h6>House Balance: '+houseBalance+'</h6> <div class="row" style="width: 100%;margin: 0;"> <div class="col-3 text-center" style="display: flex;flex-direction: column;justify-content: center;align-items: center;padding: 0 0.5rem;"> <p style="margin: 0;">Death</p> <div class="form-group"> <input class="form-control bird_death_input" type="number" min="0" required name=""> </div> </div> <div class="col-3 text-center" style="display: flex;flex-direction: column;justify-content: center;align-items: center;padding: 0 0.5rem;"> <p style="margin: 0;">Cull</p> <div class="form-group"> <input class="form-control bird_cull_input" type="number" min="0" required name=""> </div> </div> <div class="col-3 text-center" style="display: flex;flex-direction: column;justify-content: center;align-items: center;padding: 0 0.5rem;"> <p style="margin: 0;">Catch</p> <div class="form-group"> <input class="form-control bird_catch_input profitTriggerEdit" type="number" min="0" required name=""> </div> </div> <div class="col-3 text-center" style="display: flex;flex-direction: column;justify-content: center;align-items: center;padding: 0 0.5rem;"> <p style="margin: 0;">Weight</p> <div class="form-group"> <input class="form-control bird_weight_input profitTriggerEdit" type="number" min="0" step="0.01" required name=""> </div> </div> </div> </div><div class="row" style="padding:0.5rem;width:100%;">'+$(feedInput).html()+'</div> </div> </div>');
        }

        for(var i=0;i<window.view_batch.batch_record.length;i++){
          if(window.view_batch.batch_record[i].bird_record_date == $(this).attr('record_date')){
            $('.recordCard[house_id="'+window.view_batch.batch_record[i].bird_house_id+'"]').find('.bird_death_input').val(window.view_batch.batch_record[i].bird_death);
            $('.recordCard[house_id="'+window.view_batch.batch_record[i].bird_house_id+'"]').find('.bird_cull_input').val(window.view_batch.batch_record[i].bird_cull);
            $('.recordCard[house_id="'+window.view_batch.batch_record[i].bird_house_id+'"]').find('.bird_catch_input').val(window.view_batch.batch_record[i].bird_catch);
            $('.recordCard[house_id="'+window.view_batch.batch_record[i].bird_house_id+'"]').find('.bird_weight_input').val(window.view_batch.batch_record[i].bird_weight);
            $('.recordCard[house_id="'+window.view_batch.batch_record[i].bird_house_id+'"]').find('.profitTriggerEdit').attr('bird_price',window.view_batch.batch_record[i].bird_price);
          }
        }

        showPastProfit();

    }else{
        for(var i=0;i<window.houseArr.length;i++){

          for(var j=0;j<window.view_batch.batch_house_balance.length;j++){
            if(window.view_batch.batch_house_balance[j].house == window.houseArr[i].house_id){
              var houseBalance = Number(window.view_batch.batch_house_balance[j].balance);
              break;
            }
          }

            $('#batchRecord').append('<div class="col-sm-12 col-md-8"> <div class="card recordCard" house_id="'+window.houseArr[i].house_id+'"  house_balance= "'+houseBalance+'"> <div class="card-body"> <h5 class="card-title">'+window.houseArr[i].house_name+'</h5> <h6>House Balance: '+houseBalance+'</h6> <div class="row" style="width: 100%;margin: 0;"> <div class="col-4 text-center" style="display: flex;flex-direction: column;justify-content: center;align-items: center;"> <p style="margin: 0;">Death</p> <div class="form-group"> <input class="form-control bird_death_input" type="number" min="0" required name=""> </div> </div> <div class="col-4 text-center" style="display: flex;flex-direction: column;justify-content: center;align-items: center;"> <p style="margin: 0;">Cull</p> <div class="form-group"> <input class="form-control bird_cull_input" type="number" min="0" required name=""> </div> </div> <div class="col-4 text-center" style="display: flex;flex-direction: column;justify-content: center;align-items: center;"> <p style="margin: 0;">Catch</p> <div class="form-group" data-toggle="tooltip" title="Catch is only available if weight is measured."> <input class="form-control bird_catch_input" type="number" name="" disabled value="0"> </div> </div> </div> </div><div class="row" style="padding:0.5rem;width:100%;">'+$(feedInput).html()+'</div> </div> </div>');
        }

        for(var i=0;i<window.view_batch.batch_record.length;i++){
          if(window.view_batch.batch_record[i].bird_record_date == $(this).attr('record_date')){
            $('.recordCard[house_id="'+window.view_batch.batch_record[i].bird_house_id+'"]').find('.bird_death_input').val(window.view_batch.batch_record[i].bird_death);
            $('.recordCard[house_id="'+window.view_batch.batch_record[i].bird_house_id+'"]').find('.bird_cull_input').val(window.view_batch.batch_record[i].bird_cull);
            $('.recordCard[house_id="'+window.view_batch.batch_record[i].bird_house_id+'"]').find('.bird_catch_input').val(window.view_batch.batch_record[i].bird_catch);
          }
        }

    }


    for(var j=0;j<window.view_batch.batch_stock_record.length;j++){
      if(window.view_batch.batch_stock_record[j].sr_record_date == $(this).attr('record_date')){
        $('.recordCard[house_id="'+window.view_batch.batch_stock_record[j].sr_house_id+'"]').find('.feed_input[feed_id="'+window.view_batch.batch_stock_record[j].sr_item+'"]').find('.feed_quantity').val(window.view_batch.batch_stock_record[j].sr_item_quantity);
        $('.recordCard[house_id="'+window.view_batch.batch_stock_record[j].sr_house_id+'"]').find('.feed_input[feed_id="'+window.view_batch.batch_stock_record[j].sr_item+'"]').find('.feed_quantity').attr('sr_id',window.view_batch.batch_stock_record[j].sr_id);
        $('.recordCard[house_id="'+window.view_batch.batch_stock_record[j].sr_house_id+'"]').find('.feed_input[feed_id="'+window.view_batch.batch_stock_record[j].sr_item+'"]').find('.feed_stock_input').val(window.view_batch.batch_stock_record[j].sr_stock);
      }
    }



    $('#addBatchRecord').modal('show');
    $('#addBatchRecordForm').find('input').removeAttr('disabled');
    $('#addBatchRecordForm').find('textarea').removeAttr('disabled');
    $('#addBatchRecordForm').find('select').removeAttr('disabled');
    $('#addBatchRecordConfirm').removeAttr('disabled');
    $('#addBatchRecordConfirm').html('Edit');
    $('#addBatchRecordConfirm').attr('record_date', $(this).attr('record_date'));
    $('#addBatchRecordConfirm').attr('operation', 'edit');

    if(!weightEvent($(this).attr('record_date'))){
      $('.bird_catch_input').attr('disabled','true');
      $('[data-toggle="tooltip"]').tooltip();
    }

});

function batchAddRecord(){

    

}

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    return [year, month, day].join('-');
}

function weightEvent(date){

    var exist = false;

    for(var i=0;i<window.view_batch.batch_event.length;i++){
        if((date == window.view_batch.batch_event[i].event_date) && (getCategoryDesc('event',window.view_batch.batch_event[i].event_type) == 'weight')){
            exist = true;
        }
    }

    return exist;
}

$(document).on('input','.profitTrigger',function(){

  var weight = [];
  var catchment = [];

  for(var i=0;i<$('.bird_weight_input').length;i++){
    weight.push(Number($($('.bird_weight_input')[i]).val()));
  }

  for(var i=0;i<$('.bird_catch_input').length;i++){
    catchment.push(Number($($('.bird_catch_input')[i]).val()));
  }  

  for(var i=0;i<window.category.length;i++){

    if(window.category[i].category_code == window.view_batch.batch_type && window.category[i].category_level == 'batch_price'){

      var price = Number(window.category[i].category_desc);

    }

  }

  var profit = 0;

  for(var i=0;i<weight.length;i++){
    profit = ((weight[i] * catchment[i]) * price) + profit;
  }

  console.log(weight,catchment,profit);

  $('#catchProfitDisplay').html('<p>Total profit : RM' + profit.toFixed(2) + ' (price per kg: RM '+ price.toFixed(2) +')</p>' + '<a href="#" id="showPriceButton">Prices</a>');

  
})

$(document).on('input','.profitTriggerEdit',function(){
  showPastProfit();
})

function showPastProfit(){
  var weight = [];
  var catchment = [];

  for(var i=0;i<$('.bird_weight_input').length;i++){
    weight.push(Number($($('.bird_weight_input')[i]).val()));
  }

  for(var i=0;i<$('.bird_catch_input').length;i++){
    catchment.push(Number($($('.bird_catch_input')[i]).val()));
  }  

  var price = Number($('.profitTriggerEdit').attr('bird_price'));

  var profit = 0;

  for(var i=0;i<weight.length;i++){
    profit = ((weight[i] * catchment[i]) * price) + profit;
  }

  console.log(weight,catchment,profit);

  $('#catchProfitDisplay').html('<p>Total profit : RM' + profit.toFixed(2) + ' (price per kg: RM '+ price.toFixed(2) +')</p>' + '<a href="#" id="editPastPrice">Edit Past Price<a/>');
}

$(document).on('click','#editPastPrice',function(){
  var newPastPrice = prompt('Please enter the new price for current record');
  newPastPrice = Number(newPastPrice);
  $('.profitTriggerEdit').attr('bird_price',newPastPrice);
  showPastProfit();
})

function farmerReset(data){
  console.log("You're not a farmer.");
}



</script>
