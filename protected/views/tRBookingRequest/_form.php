
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'trbooking-request-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php /*?><?php 
	date_default_timezone_set('Asia/Colombo'); 
?><?php */?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    <table width="550" border="1">

	<div class="row">
    <tr><td>
    	<?php
			$user = Yii::app()->getModule('user')->user()->username;
			//echo $user;exit;
		?>
		<?php echo $form->labelEx($model,'User_ID'); ?>
        </td><td>
		<?php echo $form->textField($model,'User_ID',array('value'=>$user,'readonly'=>true)); ?>
		<?php echo $form->error($model,'User_ID'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Vehicle_Category_ID'); ?>
        </td><td>
		<?php /*?><?php echo $form->textField($model,'Vehicle_Category_ID'); ?><?php */?>
        <?php echo $form->dropdownlist($model,'Vehicle_Category_ID',CHtml::listData(VehicleCategory::model()->findAll(),	      	      	'Vehicle_Category_ID','Category_Name'),array('empty    	'=>'--please select--'));  ?>
		<?php echo $form->error($model,'Vehicle_Category_ID'); ?>
        </td></tr>
	</div>
    
    <div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'No_of_Passengers'); ?>
        </td><td>
		<?php echo $form->textField($model,'No_of_Passengers'); ?>
		<?php echo $form->error($model,'No_of_Passengers'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'From'); ?>
        </td><td>
		<?php /*?><?php echo $form->textField($model,'From'); ?><?php */?>
       	<?php $this->widget('zii.widgets.timepicker.timepicker', array(
     		'model'=>$model,
     		'name'=>'From', 
   			)); ?>       
		<?php echo $form->error($model,'From'); ?>
        </td></tr>
	</div>

   	<div class="row">
    <tr><td>
  		<?php echo $form->labelEx($model,'To'); ?>
        </td><td>
   		<?php $this->widget('application.extensions.timepicker.timepicker', array(
     	'model'=>$model,
     	'name'=>'To', 
   		)); ?>       
  		<?php echo $form->error($model,'To'); ?>
        </td></tr>
	</div>
    
    <div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Description'); ?>
        </td><td>
		<?php echo $form->textArea($model,'Description',array('rows'=>6, 'cols'=>40)); ?>
		<?php echo $form->error($model,'Description'); ?>
        </td></tr>
	</div>

	<div class="row" style="display:none">
    
		<?php echo $form->labelEx($model,'Booking_Status'); ?>
		<?php echo $form->textField($model,'Booking_Status',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'Booking_Status'); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->labelEx($model,'Allocation_Type_ID'); ?>
		<?php echo $form->textField($model,'Allocation_Type_ID',array('value'=>3)); ?>
		<?php echo $form->error($model,'Allocation_Type_ID'); ?>
	</div>


<?php 
date_default_timezone_set('Asia/Colombo');
$date=date('Y-m-d'); ?>
	<div class="row" style="display:none">
		<?php echo $form->labelEx($model,'Requested_Date'); ?>
		<?php echo $form->textField($model,'Requested_Date',array('value'=>$date)); ?>
		<?php echo $form->error($model,'Requested_Date'); ?>
	</div>

	<?php date_default_timezone_set('Asia/Colombo'); ?>
	<div class="row">
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));
		}
		else {
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50));	
		}
		 ?>
	</div>

	<div class="row">
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_date',array('value'=>date("Y-m-d : H:i:s", time())));
		} else {
		echo $form->hiddenField($model,'add_date',array());	
		}
		?>
	</div>
    
   <div class="row">
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>'Not Edited'));
		} else {
		echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));   	
		}
		?>
	</div>

	<div class="row">
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'edit_date',array('value'=>'Not Edited'));
		} else {
		echo $form->hiddenField($model,'edit_date',array('value'=>date("Y-m-d : H:i:s", time())));	
		}
		?>
	</div>
    </table>

	<div class="row buttons" style="padding-left:75%;font-weight:bold">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save');?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->