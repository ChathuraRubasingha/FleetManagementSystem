</script>

<style type="text/css">

.allocate{
	margin-left:80%;
	width:50px;
	float:left;
}

.manage{
	margin-left:91%;
	margin-top:-15px;
	width:50px;
}

#showMaAllocationTypeDialog
{
	width:105px;
	height:30px;
	display:inline-block;
	background-position: -5px 5px;	
	border:none;
	background-color:transparent !important;/**/
	background-image:url(images/addBtn2.png);
	background-repeat:no-repeat;
}

#showMaAllocationTypeDialog:hover
{
	/*position:0, -32px;*/
	background-position: -4px 4px;
}
#showVehicleCategoryDialog
{
	width:105px;
	height:30px;
	display:inline-block;
	background-position: -5px 5px;	
	border:none;
	background-color:transparent !important;
	background-image:url(images/addBtn2.png);
	background-repeat:no-repeat;
}

#showVehicleCategoryDialog:hover
{
	background-position: -4px 4px;
}
#showMaMakeDialog
{
	width:105px;
	height:30px;
	display:inline-block;
	background-position: -5px 5px;	
	border:none;
	background-color:transparent !important;
	background-image:url(images/addBtn2.png);
	background-repeat:no-repeat;
}

#showMaMakeDialog:hover
{
	background-position: -4px 4px;
}

#showMaModelDialog
{
	width:105px;
	height:30px;
	display:inline-block;
	background-position: -5px 5px;	
	border:none;
	background-color:transparent !important;
	background-image:url(images/addBtn2.png);
	background-repeat:no-repeat;
}

#showMaModelDialog:hover
{
	background-position: -4px 4px;
}

#showFuelTypeDialog
{
	width:105px;
	height:30px;
	display:inline-block;
	background-position: -5px 5px;	
	border:none;
	background-color:transparent !important;
	background-image:url(images/addBtn2.png);
	background-repeat:no-repeat;
}

#showFuelTypeDialog:hover
{
	background-position: -4px 4px;
}

#showMaTyreSizeDialog
{
	width:105px;
	height:30px;
	display:inline-block;
	background-position: -5px 5px;	
	border:none;
	background-color:transparent !important;
	background-image:url(images/addBtn2.png);
	background-repeat:no-repeat;
}

#showMaTyreSizeDialog:hover
{
	background-position: -4px 4px;
}

#showMaTyreTypeDialog
{
	width:105px;
	height:30px;
	display:inline-block;
	background-position: -5px 5px;	
	border:none;
	background-color:transparent !important;
	background-image:url(images/addBtn2.png);
	background-repeat:no-repeat;
}

#showMaTyreTypeDialog:hover
{
	background-position: -4px 4px;
}

#showMaBatteryTypeDialog
{
	width:105px;
	height:30px;
	display:inline-block;
	background-position: -5px 5px;	
	border:none;
	background-color:transparent !important;
	background-image:url(images/addBtn2.png);
	background-repeat:no-repeat;
}

#showMaBatteryTypeDialog:hover
{
	background-position: -5px 5px;
}

#showVehicleStatusDialog
{
	width:105px;
	height:30px;
	display:inline-block;
	background-position: -5px 5px;	
	border:none;
	background-color:transparent !important;
	background-image:url(images/addBtn2.png);
	background-repeat:no-repeat;
}

#showVehicleStatusDialog:hover
{
	background-position: -4px 4px;
}


td
{
	padding:0;
}

input[type=text], input[type=password]
{

  -webkit-border-radius: 5px;
  -webkit-padding-end: 20px;
  -webkit-padding-start: 2px;
  border-radius:5px;
 box-shadow: inset 0 10px 10px #DAF0FD;
  background-position: center right;
  background-repeat: no-repeat;
   border:#2c343c 1px solid;
  color: #555;
  font-size: inherit;
  margin: 0;
  padding-top: 2px;
  padding-bottom: 2px;

}

select  {
  outline: 0;
  overflow: hidden;
  height: 25px;
  box-shadow: inset 0 10px 10px #DAF0FD;
  color:#000000;
  border:#2c343c 1px solid;
  padding:0;
  -moz-border-radius:6px;
 -webkit-border-radius:6px;
 border-radius:5px;
}



</style>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'traccident-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php
  	$vehicleId = Yii::app()->session['accidentVehicleId'];
?>

<?php 
	date_default_timezone_set('Asia/Colombo'); 
?>

<div class="classname" style="width:200px; height:28px; margin-left:270px; font-size:25px"><p align="center"><b><?php echo $vehicleId; ?></b></p></div> 

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->hiddenfield($model,'Vehicle_No'); ?>
        <?php echo $form->hiddenfield($model,'Vehicle_No',array('size'=>20,'value'=>$vehicleId,'readonly'=>true)); ?>
		<?php /*?><?php echo $form->textField($model,'Vehicle_No',array('size'=>20,'maxlength'=>20)); ?><?php */?>
		<?php echo $form->error($model,'Vehicle_No'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'Driver_ID'); ?>
        <?php echo $form->dropdownlist($model,'Driver_ID',CHtml::listData(tRAccident ::model()->getDrivers(),'Driver_ID','Full_Name'),array('width'=> '25', 'empty'=>'please select'));  ?>
		<?php /*?><?php echo $form->textField($model,'Driver_ID'); ?><?php */?>
		<?php echo $form->error($model,'Driver_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Accident_Place'); ?>
		<?php echo $form->textField($model,'Accident_Place',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Accident_Place'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Date_and_Time'); ?>
        <?php $this->widget('application.extensions.timepicker.timepicker', array(
     	'model'=>$model,
     	'name'=>'Date_and_Time', 
   		)); ?> 
		<?php /*?><?php echo $form->textField($model,'Date_and_Time'); ?><?php */?>
		<?php echo $form->error($model,'Date_and_Time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Details'); ?>
		<?php echo $form->textArea($model,'Details',array('rows'=>6, 'cols'=>40)); ?>
		<?php echo $form->error($model,'Details'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Police_Station'); ?>
		<?php echo $form->textField($model,'Police_Station',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'Police_Station'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Address'); ?>
		<?php echo $form->textField($model,'Address',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Police_Report_No'); ?>
		<?php echo $form->textField($model,'Police_Report_No',array('size'=>60,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'Police_Report_No'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Accident_Type'); ?>
        <?php echo $form->dropDownList($model,'Accident_Type',array(""=>"Please Select","Major"=>"Major","Minor"=>"Minor")); ?>
		<?php /*?><?php echo $form->textField($model,'Accident_Type',array('size'=>60,'maxlength'=>150)); ?><?php */?>
		<?php echo $form->error($model,'Accident_Type'); ?>
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

	<div class="row buttons" style="margin-left:650px">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->