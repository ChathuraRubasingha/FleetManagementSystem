

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<?php /*?>	<div class="row">
		<?php echo $form->label($model,'Fuel_Providing_ID'); ?>
		<?php echo $form->textField($model,'Fuel_Providing_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Fuel_Request_ID'); ?>
		<?php echo $form->textField($model,'Fuel_Request_ID'); ?>
	</div><?php */?>

	<div class="row">
		<?php echo $form->label($model,'Fuel_Order_No'); ?>
		<?php echo $form->textField($model,'Fuel_Order_No'); ?>
	</div>

	<?php /*?><div class="row">
		<?php echo $form->label($model,'Fuel_Station'); ?>
		<?php echo $form->textField($model,'Fuel_Station',array('size'=>60,'maxlength'=>100)); ?>
	</div><?php */?>

	<div class="row">
		<?php echo $form->label($model,'Vehicle_No'); ?>
		<?php echo $form->textField($model,'Vehicle_No',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<?php /*?><div class="row">
		<?php echo $form->label($model,'Fuel_Type_ID'); ?>
		<?php echo $form->textField($model,'Fuel_Type_ID'); ?>
	</div><?php */?>

	<div class="row">
		<?php echo $form->label($model,'Fuel_Pumped_Date'); ?>
		<?php echo $form->textField($model,'Fuel_Pumped_Date'); ?>
	</div>

	<?php /*?><div class="row">
		<?php echo $form->label($model,'Fuel_Amount'); ?>
		<?php echo $form->textField($model,'Fuel_Amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Payable_Amount'); ?>
		<?php echo $form->textField($model,'Payable_Amount',array('size'=>50,'maxlength'=>50)); ?>
	</div><?php */?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->