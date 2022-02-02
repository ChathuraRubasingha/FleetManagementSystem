
<?php
$vNo ='';
if(isset($_REQUEST['ReportGridMemberID']))
{
    $vNo = $_REQUEST['ReportGridMemberID'];
}
?>

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
    'Vehicle Details'=>array('report/vehicleMaintenanceCost'),
    'Vehicle Maintenance Cost Report'
);
?>
<script>
    $(document).ready(function()
    {
        $('#vehicleMaintenanceCostDateForm_Valid_From').Zebra_DatePicker();
        $('#vehicleMaintenanceCostDateForm_Valid_To').Zebra_DatePicker();
    });

</script>



<div class="container body">

<div class="col-xs-4" style="width:32%;float:left;margin-left:5%">
    <div class="panel panel-default rating-widget">
        <div class="panel-heading large">
            <h4 class="panel-title">VEHICLE MAINTENANCE</h4>
        </div>
        <div class="panel-body">
            <ul class="list-unstyled">
                <?php echo MaVehicleRegistry::model()->menuarray('ReportMaintenance'); ?>
            </ul>
        </div>
        <div class="panel-footer text-center"></div>
    </div>     
</div>

<div class="col-xs-4" style="width:60%;height:50%;float:left">
    <div class="panel panel-default rating-widget">
        <div class="panel-heading large">
            <h4 class="panel-title">Vehicle Maintenance Cost Report (<?php echo $vNo?>)</h4>
        </div>
        <div class="panel-body"  style="height:auto">
           <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'vehicleRepairServiceDate-form',
                        'enableClientValidation'=>true,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                        ),'htmlOptions'=>array('target'=>'_blank')));
                    ?>


                            <p class="note">Field with <span class="required">*</span> is required.</p>
                            <?php echo $form->errorSummary($model); ?>
                            <div class="formTable">
                               
                                
                                    <div class="tblrow">
                                        <div class="tdOne"><?php echo $form->labelEx($model,'Valid_From'); ?></div>
                                        <div class="tdTwo"><?php echo $form->textField($model,'Valid_From',array('size'=>20, 'autocomplete'=>'off','class'=>"zDatepicker" )); ?>
                                    <?php echo $form->error($model,'Valid_From'); ?></div>
                                    </div>
                                
                                    <div class="tblrow">
                                        <div class="tdOne"><?php echo $form->labelEx($model,'Valid_To'); ?></div>
                                        <div class="tdTwo"><?php echo $form->textField($model,'Valid_To',array('size'=>20, 'autocomplete'=>'off','class'=>"zDatepicker  " )); ?>
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



    