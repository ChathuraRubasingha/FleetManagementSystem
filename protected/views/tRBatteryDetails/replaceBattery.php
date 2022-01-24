
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'trbattery-details-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php
  	$vehicleId = Yii::app()->session['maintenVehicleId'];
	$batteryType = Yii::app()->request->getQuery('batteryType');
?>
<div class="group" style="width:20%;  height:280px; float:left; margin-left:3%; margin-top:2.4%">
    <div id="menu"  style="width:20%; float:left; padding-left:2%; padding-top:2%">
        
        <ul>
               <?php echo CHtml::link('<img src="images/back.png" alt="back" width="25px" style="padding:0 125px 0 50px;"/>',array('/maVehicleRegistry/maintanenceview&id='.$vehicleId)); ?>
                
                <li><?php echo CHtml::link('Battery Requests',array('/tRBatteryDetails/battery')); ?></li>
                                
               <!-- <li><?php #echo CHtml::link('Approve Repair Estimate',array('/tRRepairEstimateDetails/estimate')); ?></li>-->
                
                 <li><?php echo CHtml::link('Battery Replacement',array('/tRBatteryDetails/replace&type=replace')); ?></li>
                 
                <li><?php echo CHtml::link('Pending Battery Requests',array('/tRBatteryDetails/pendingBatteryRequests')); ?></li>
                <li><?php echo CHtml::link('Approved Battery Requests',array('/tRBatteryDetails/approvedBatteryRequests')); ?></li>
                <li><?php echo CHtml::link('Disapproved Battery Requests',array('/tRBatteryDetails/disapprovedBatteryRequests')); ?></li>
                <li><?php echo CHtml::link('Rejected Battery Requests',array('/tRBatteryDetails/rejectedBatteryRequests')); ?></li>
                <li><?php echo CHtml::link('Completed Battery Requests',array('/tRBatteryDetails/completedBatteryRequests')); ?></li>
            </ul>
            
            <!--<ul>
            	<li><?php #echo CHtml::link('Back to main',array('/tRLicense/Create')); ?></li>
            
                <li><?php #echo CHtml::link('New Battery Request',array('/tRBatteryDetails/create')); ?></li>
                
                <li><?php #echo CHtml::link('Approve Battery Requests',array('/tRBatteryDetails/admin')); ?></li>
                
                <li><?php #echo CHtml::link('Battery Replacement',array('/tRBatteryDetails/replaceBatteryDetails')); ?></li>
                            
            </ul>-->

	</div>
    
</div>

 <div class="groups" style="margin-left:300px;"><h1>Battery Replacement</h1><div class="classname" style="width:200px; height:28px; margin-left:272px; font-size:25px"><p align="center"><b><?php echo $vehicleId; ?></b></p></div>

<div class="row">
	<?php //echo $form->labelEx($model,'Battery_Type_ID'); ?>
	<?php //echo $form->textField($model,'Battery_Type_ID',array('value'=>TRClaimeDetails ::model()->getBatteryType($batteryType)));?>
	<?php //echo $form->error($model,'Battery_Type_ID'); ?>
</div>
<table width="550">
<div class="row">
       <tr>
        <td>
		<?php echo $form->labelEx($model,'Replace_Date'); ?>
         </td>
            <td>
        <?php $this->widget('application.extensions.timepicker.timepicker', array(
     	'model'=>$model,
     	'name'=>'Replace_Date', 
   		)); ?> 
		<?php /*?><?php echo $form->textField($model,'Date_and_Time'); ?><?php */?>
		<?php echo $form->error($model,'Replace_Date'); ?>
              </td>
        </tr>
	</div>
<div class="row">
 <tr>
        <td>
	<?php #echo $form->labelEx($model,'Replace_Status'); ?>
     </td>
            <td>
	<?php #echo $form->textField($model,'Replace_Status',array('size'=>60,'maxlength'=>100)); ?>
	<?php #echo $form->error($model,'Replace_Status'); ?>
          </td>
        </tr>
</div>
<div class="row buttons">
 <tr>
        <td>
<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
      </td>
        </tr>
</div></table>
<?php $this->endWidget(); ?>
</div>


