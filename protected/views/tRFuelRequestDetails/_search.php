

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php /*?><div class="row">
		<?php echo $form->label($model,'Fuel_Request_ID'); ?>
		<?php echo $form->textField($model,'Fuel_Request_ID'); ?>
	</div><?php */?>

	<div class="row">
		<?php echo $form->label($model,'Vehicle_No'); ?>
		<?php echo $form->textField($model,'Vehicle_No',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<?php /*?><div class="row">
		<?php echo $form->label($model,'Required_Fuel_Capacity'); ?>
		<?php echo $form->textField($model,'Required_Fuel_Capacity',array('size'=>4,'maxlength'=>4)); ?>
	</div><?php */?>

	<div class="row">
		<?php echo $form->label($model,'Driver_ID'); ?>
		<?php echo $form->textField($model,'Driver_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Request_Date'); ?>
		<?php echo $form->textField($model,'Request_Date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Fuel_Balance'); ?>
		<?php echo $form->textField($model,'Fuel_Balance',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Meter_Reading'); ?>
		<?php echo $form->textField($model,'Meter_Reading'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Approve_Status'); ?>
		<?php echo $form->textField($model,'Approve_Status',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<!--<div class="row">
		<?php /*?><?php echo $form->label($model,'add_by'); ?>
		<?php echo $form->textField($model,'add_by',array('size'=>50,'maxlength'=>50)); ?><?php */?>
	</div>

	<div class="row">
		<?php /*?><?php echo $form->label($model,'add_date'); ?>
		<?php echo $form->textField($model,'add_date'); ?><?php */?>
	</div>

	<div class="row">
		<?php /*?><?php echo $form->label($model,'edit_by'); ?>
		<?php echo $form->textField($model,'edit_by',array('size'=>50,'maxlength'=>50)); ?><?php */?>
	</div>

	<div class="row">
		<?php /*?><?php echo $form->label($model,'edit_date'); ?>
		<?php echo $form->textField($model,'edit_date',array('size'=>50,'maxlength'=>50)); ?><?php */?>
	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->