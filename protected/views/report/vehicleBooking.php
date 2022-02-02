

<style>
    .panel
    {
        margin-right: 20px;
    }

</style>

<link rel="stylesheet" href="css/zebra.css" type="text/css">
<script type="text/javascript" src="js/zebra_datepicker.js"></script>


<?php
$this->breadcrumbs=array(
    'Reports'=>array('notificationConfiguration/report'),
    'Vehicle Allocation Report'
);
?>
<script>
    $(document).ready(function()
    {
        $('#vehicleBookingForm_Valid_From').Zebra_DatePicker();
        $('#vehicleBookingForm_Valid_To').Zebra_DatePicker();
    });
</script>



<div class="container body">

    <div class="col-xs-4" style="width:32%;height:100%;float:left">
    <div class="panel panel-default rating-widget">
        <div class="panel-heading large">
            <h4 class="panel-title">VEHICLE MOVEMENT</h4>
        </div>
        <div class="panel-body">
            <ul class="list-unstyled">
                <?php echo MaVehicleRegistry::model()->menuarray('ReportMovement'); ?>
            </ul>
        </div>
        <div class="panel-footer text-center"></div>
    </div>     
</div>


    <div class="col-xs-4" style="width:60%;height:50%;float:left">
        <div class="panel panel-default rating-widget">
            <div class="panel-heading large">
                <h4 class="panel-title">Vehicle Booking Report - Status wise</h4>
            </div>
            <div class="panel-body"  style="height:auto">
               <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'vehicleBooking-form',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                    ),'htmlOptions'=>array('target'=>'_blank')));
                ?>


                <p class="note">Field with <span class="required">*</span> is required.</p>
                <?php echo $form->errorSummary($model); ?>

                <div class="formTable">

                    <div class="tblrow">
                        <div class="tdOne"><?php echo $form->labelEx($model,'Booking_Status'); ?></div>
                        <div class="tdTwo"><?php echo $form->dropDownList($model,'Booking_Status',array("All"=>"All", "Approved"=>"Approved","Assigned"=>"Assigned","Completed"=>"Completed" ,"Disapproved"=>"Disapproved", "Pending"=>"Pending","Rejected"=>"Rejected"),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
                                        <?php echo $form->error($model,'Booking_Status'); ?></div>
                    </div>
                    
                     <div class="tblrow">
                        <div class="tdOne"><?php echo $form->labelEx($model,'Valid_From'); ?></div>
                        <div class="tdTwo"><?php echo $form->textField($model,'Valid_From',array('size'=>20, 'autocomplete'=>'off','class'=>"zDatepicker" )); ?>
                                    <?php echo $form->error($model,'Valid_From'); ?></div>
                    </div>
                    
                     <div class="tblrow">
                        <div class="tdOne"><?php echo $form->labelEx($model,'Valid_To'); ?></div>
                        <div class="tdTwo"><?php echo $form->textField($model,'Valid_To',array('size'=>20, 'autocomplete'=>'off','class'=>"zDatepicker" )); ?>
                                    <?php echo $form->error($model,'Valid_To'); ?></div>
                    </div>
                                 

                    <div class="row" style="padding-left:37%;font-weight:bold">
                        <?php echo CHtml::submitButton('Preview');?>
                    </div>

                </div>

                <?php $this->endWidget(); ?>
            </div>
            <div class="panel-footer text-center"></div>
        </div>     
    </div>
</div>

             





