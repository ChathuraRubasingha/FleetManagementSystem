<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'Booking_Approval_ID'); ?>
		<?php echo $form->textField($model,'Booking_Approval_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Approved_Date'); ?>
		<?php echo $form->textField($model,'Approved_Date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'New_Booking_Request_Date'); ?>
		<?php echo $form->textField($model,'New_Booking_Request_Date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'In_Time'); ?>
		<?php echo $form->textField($model,'In_Time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Out_Time'); ?>
		<?php echo $form->textField($model,'Out_Time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Mileage'); ?>
		<?php echo $form->textField($model,'Mileage'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'No_of_Pessengers'); ?>
		<?php echo $form->textField($model,'No_of_Pessengers'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->