

<style>
    .panel
    {
        margin-right: 20px;
    }
    #AccidentReportVehicleWiseForm_Show_Images
    {
        width: 15px;
    }
</style>

<link rel="stylesheet" href="css/zebra.css" type="text/css">
<script type="text/javascript" src="js/zebra_datepicker.js"></script>


<?php
$this->breadcrumbs=array(
    'Reports'=>array('notificationConfiguration/report'),
    'Vehicle Details Report - Category wise '
);
?>

<script>
    
    $(document).ready(function()
    {
        $('.datepicker').Zebra_DatePicker();
    });
    
</script>


<div class="container body">

    <div class="col-xs-4" style="width:32%;height:100%;float:left">
    <div class="panel panel-default rating-widget">
        <div class="panel-heading large">
            <h4 class="panel-title">VEHICLE REGISTRY</h4>
        </div>
        <div class="panel-body" style="height:263px">
            <ul class="list-unstyled">
                <?php echo MaVehicleRegistry::model()->menuarray('ReportVehicleReg'); ?>
            </ul>
        </div>
        <div class="panel-footer text-center"></div>
    </div>     
</div>


    <div class="col-xs-4" style="width:60%;height:50%;float:left">
        <div class="panel panel-default rating-widget">
            <div class="panel-heading large">
                <h4 class="panel-title">Accident Details Report - Vehicle wise</h4>
            </div>
            <div class="panel-body"  style="height:auto">
               <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'Accident-details-form',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                    ),'htmlOptions'=>array('target'=>'_blank')));
                ?>


                <p class="note">Fields with <span class="required">*</span> are required.</p>
                <?php echo $form->errorSummary($model); ?>

                <div class="formTable">

                    <div class="tblrow">
                        <div class="tdOne"><?php  echo $form->labelEx($model,'Vehicle_No'); ?></div>
                        <div class="tdTwo"><?php echo $form->dropdownlist($model,'Vehicle_No',CHtml::listData($model->getVehicleListForLocation(),'Vehicle_No','Vehicle_No', 'Vehicle_Category_ID'),array('prompt' => '--- Please Select ---','class'=>'midSelect'));  ?>
                            <?php echo $form->error($model,'Vehicle_No');?></div>
                    </div>
                    
                    <div class="tblrow">
                        <div class="tdOne"><?php  echo $form->labelEx($model,'From_Date'); ?></div>
                        <div class="tdTwo"><?php echo $form->textField($model,'From_Date',array('size'=>24, 'autocomplete'=>'off','class'=>"datepicker" )); ?>
                            <?php echo $form->error($model,'From_Date');?></div>
                    </div>
                    
                    <div class="tblrow">
                        <div class="tdOne"><?php  echo $form->labelEx($model,'To_Date'); ?></div>
                        <div class="tdTwo"><?php echo $form->textField($model,'To_Date',array('size'=>24, 'autocomplete'=>'off','class'=>"datepicker" )); ?>
                            <?php echo $form->error($model,'To_Date');?></div>
                    </div>
                    
                    <div class="tblrow">
                        <div class="tdOne"><?php  echo $form->labelEx($model,'Show_Images'); ?></div>
                        <div class="tdTwo"><?php echo $form->checkBox($model,'Show_Images',array('size'=>24, 'checked'=>true )); ?>
                            <?php //echo $form->error($model,'To_Date');?></div>
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


