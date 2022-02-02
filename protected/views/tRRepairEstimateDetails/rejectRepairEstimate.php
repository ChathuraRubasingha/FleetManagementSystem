<style>
    input[type="submit"]
    {
        margin-right: 0px;
    }
</style>

<?php

    $estID = Yii::app()->request->getQuery('estimateId');
    $vehicleId = Yii::app()->request->getQuery('vid');
   

?>

<script type="text/javascript">
 $(document).ready(function()
 {
     var reject = false;
     var height = $("body").height();

     $('#btnConfirmOk').click(function()
     {
         var reason = $('#TRRepairEstimateDetails_Estimate_Status_Reason').val();
         //alert(reason);
         if(reject)
         {
            $.ajax
            ({
                type : 'POST',
                url  : '<?php echo Yii::app()->createAbsoluteUrl("tRRepairEstimateDetails/reject") ?>',
                data : {'EstimateID':'<?php echo $estID; ?>', "reason":reason},
                success : function(data)
                {
                    //alert(data);
                    if(data == 'OK')
                    {
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
        var reason = $('#TRRepairEstimateDetails_Estimate_Status_Reason').val();

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
   window.location = "<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=TRRepairEstimateDetails/DashboardApprovedRequests";    
}
 </script>
 

           
                
 <div class="container body">
    <div id="main" role="main">
        <div class="row rest-view" itemscope itemtype="http://schema.org/Restaurant">

            
            
            <div class="col-xs-11">


                <div class="panel panel-default">
                    <div class="panel-heading large">
                        <h1 id="rest-title" class="panel-title" itemprop="name">Reject Repair Estimate</h1>
                    </div>

                    <div class="panel-body">
                        
                        <?php $this->widget('zii.widgets.CDetailView', array(
                            'data'=>$model,
                            'attributes'=>array(
                                'Vehicle_No',
                                array('label'=>'Garage', 'value'=>$request->garage->Garage_Name),
                                'Total_Estimate',
                                'Estimate_Date',

                            ),
                        )); ?>
                        
                        <?php $form=$this->beginWidget('CActiveForm', array(
                            'id'=>'trvehicle-booking-form',
                            'enableAjaxValidation'=>false,
                            )); ?>

                        <br/>
                        <div class="tblRow" style="display: none">
                            <div class="tdOne"><?php echo CHtml::label('Reject Reason', 'Estimate_Status_Reason'); ?></div>
                            <div class="tdTwo"><?php echo $form->textArea($model, 'Estimate_Status_Reason', array('rows' => 2, 'cols' => 56)); ?>
                                <?php echo $form->error($model, 'Estimate_Status_Reason'); ?></div>
                        </div>
                        
                        <?php $this->endWidget(); ?>
                        
                        <div class="row buttons" style="margin-top: 10px; float: left; margin-left: 413px; ">

                            <?php echo CHtml::submitbutton('Reject', array('id'=>'Reject_btn')); ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo CHtml::submitbutton('Exit', array('id'=>'Exit_btn')); ?>

                        </div>


                    </div>
                </div>




            </div>
            
        </div>

    </div>
</div>               




		
