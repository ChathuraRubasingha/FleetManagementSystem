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
	'Vehicle Mileage Report'
);
?>

<div class="container body">

<div class="col-xs-4" style="width:30%;float:left;margin-left:5%">
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
            <h4 class="panel-title">Vehicle Mileage Report</h4>
        </div>
        <div class="panel-body"  style="height:auto">
            <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'vehicleMileage-form',
                        'enableClientValidation'=>true,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                        ),'htmlOptions'=>array('target'=>'_blank')));

                    ?>


                           <!-- <p class="reportInfo">Select Vehicle Category to Generate Vehicle Mileage Report</p>-->

                            <p class="note">Field with <span class="required">*</span> is required.</p>
                            <?php echo $form->errorSummary($model); ?>
                            <div class="formTable">
                               
                                
                                    <div class="tblrow">
                                        <div class="tdOne"><?php  echo $form->labelEx($model,'Vehicle_Category_ID'); ?></div>
                                        <div class="tdTwo"><?php echo $form->dropdownlist($model,'Vehicle_Category_ID',CHtml::listData(VehicleCategory::model()->findAllVehicleCategories(),'Vehicle_Category_ID','Category_Name'),array('prompt' => '--- Please Select ---'));  ?>
                                            <?php echo $form->error($model,'Vehicle_Category_ID');?></div>
                                    </div>
                                <div class="row buttons" style="margin-left:60%">
                                <?php echo CHtml::submitButton('Preview');?>
                            </div>

                            </div>



                            


                        <?php $this->endWidget(); ?>
        </div>
        <div class="panel-footer text-center"></div>
    </div>     
</div>
</div>




