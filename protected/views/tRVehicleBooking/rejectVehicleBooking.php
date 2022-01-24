<style>
    .bttnn
    {
        width: 100px;
    }
</style>

<?php

    $requestid = Yii::app()->request->getQuery('requestId');
    $vehicleId = Yii::app()->request->getQuery('vid');
    $driver = Yii::app()->request->getQuery('driver');
    $approvalID = Yii::app()->request->getQuery('appID');


?>


            
         
 <script type="text/javascript">
 $(document).ready(function()
 {
     var removed = false;
     var reject = false;
     var height = $("body").height();

    $('#Remove_btn').click(function()
    {
        removed  = true;
        $(".ontop").height(height);
        $("#Confirm").fadeIn(500);
        $('#Confirm p').html('Are you sure you want to remove this request from assigned list?');
        $("#popDiv").fadeIn(500);

    });

     $('#btnConfirmOk').click(function()
     {
         
         if(removed)
         {
             
             $.ajax
             ({
                 type : 'POST',
                 url : '<?php echo Yii::app()->createAbsoluteUrl("TRVehicleBooking/RemoveRequestFromAssignedList") ?>',
                 data : {'requestId':'<?php echo $requestid; ?>'},
                 success : function(data)
                 {
                    var height = $("body").height();//- $("#header").height() + $("#footer").height()
                    $(".ontop").height(height);
                    $("#errorConfirm").fadeIn(500);
                    $('#errorConfirm p').html('Successfully Removed');
                    $("#popDiv").fadeIn(500);
                    
                    setTimeout(function()
                    {
                        gotoPreviousUrl();
                    },3000);
                 },
                 dataType:'html'
             });
            
             
         }
         if(reject)
         {
            $.ajax
            ({
                type : 'POST',
                url : '<?php echo Yii::app()->createAbsoluteUrl("TRVehicleBooking/RejectAssignedBooking") ?>',
                data : {'requestId':<?php echo $requestid; ?>},
                success : function(data)
                {
                    if(data == 'OK')
                    {
                        var height = $("body").height();//- $("#header").height() + $("#footer").height()
                        $(".ontop").height(height);
                        $("#errorConfirm").fadeIn(500);
                        $('#errorConfirm p').html('Successfully Rejected');
                        $("#popDiv").fadeIn(500);

                       setTimeout(function()
                       {
                           gotoPreviousUrl();
                       },3000);
                   }
                   else
                   {
                       alert('Please Try Again');
                   }
                }
            });            
         }
     });

    $('#Reject_btn').click(function()
    {
        var reason = $('#TRVehicleBooking_Booking_Status_Reason').val();

        $("#popDiv").height(height);
        $("#Confirm").fadeIn(500);
        if(reason =='')
        {
            $('.tblRow').show();
            $('#Confirm p').html('Reject Reason is required');
        }
        else
        {
            reject = true;
            $('#Confirm p').html('Are you sure you want to reject above request(s)?');
        }

        $("#popDiv").fadeIn(500);
        return false;

    });
            
    $('#Exit_btn').click(function()
    {
        gotoPreviousUrl();
    });
});

function gotoPreviousUrl()
{
    var appID = '<?php echo $approvalID; ?>';
    var driver = '<?php echo $driver; ?>';
    var vehicle = '<?php echo $vehicleId; ?>';
    //alert(driver);
    //editApprovedBookings&ApproveID=7&VNo=WP+MN+1553&drvr=Susil
    //window.location = "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=tRVehicleBooking/canceled&requestid=<?php echo $requestid; ?>";
    window.location = "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=tRVehicleBooking/editApprovedBookings&ApproveID="+appID+"&VNo="+vehicle+"&drvr="+driver;
    
}
 </script>
             
  

 <div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            
            
            <div class="col-xs-11">


                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Remove from Assigning List or Reject Booking Requests</h1>
                    </div>

                    <div class="panel-body">

                        <?php $this->widget('zii.widgets.CDetailView', array(
                            'data'=>$model,
                            'attributes'=>array(
                                array('label'=>'Requested By', 'value'=>$model->user->profile->firstname),
                                array('label'=>'Vehicle Category', 'value'=>$model->vehicleCategory->Category_Name),
                                array('label'=>'Driver', 'value'=>$model->approval->drivers->Full_Name),
                                array('label'=>'Vehicle No', 'value'=>$vehicleId),
                                'Requested_Date',
                                'Place_from',
                                'Place_to',
                                'From',
                                'To','Approved_By',
                                'Approved_Date',
                                'Assigned_By',
                                'Assigned_Date',
                            ),
                        )); ?>
                        <?php $form=$this->beginWidget('CActiveForm', array(
                            'id'=>'trvehicle-booking-form',
                            'enableAjaxValidation'=>false,
                            )); ?>

                        <br/>
                         <div class="tblRow" style="display:none;">
                            <div class="tdOne"><?php echo CHtml::label('Reject Reason', 'Booking_Status_Reason'); ?></div>
                            <div class="tdTwo"><?php echo $form->textArea($model, 'Booking_Status_Reason', array('rows' => 2, 'cols' => 56)); ?>
                                <?php echo $form->error($model, 'Booking_Status_Reason'); ?></div>
                        </div>
                        
                        <?php $this->endWidget(); ?>
                        
                        
                        <div class="btns" style="width:55%; margin-top:50px; margin-bottom:20px; float:right;">

                            <?php echo CHtml::button('Remove', array('id'=>'Remove_btn', 'class'=>'otherBtns','style'=>'margin-right:-20px;')); ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo CHtml::button('Reject', array('id'=>'Reject_btn', 'class'=>'otherBtns','style'=>'margin-right:-20px;')); ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo CHtml::button('Exit', array('id'=>'Exit_btn', 'class'=>'otherBtns')); ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;


                        </div>

                    </div>
                </div>




            </div>
            
        </div>

    </div>
</div>