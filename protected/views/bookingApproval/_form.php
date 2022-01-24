<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'booking-approval-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Approved_Date'); ?>
		<?php echo $form->textField($model,'Approved_Date'); ?>
		<?php echo $form->error($model,'Approved_Date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'New_Booking_Request_Date'); ?>
		<?php echo $form->textField($model,'New_Booking_Request_Date'); ?>
		<?php echo $form->error($model,'New_Booking_Request_Date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'In_Time'); ?>
		<?php echo $form->textField($model,'In_Time'); ?>
		<?php echo $form->error($model,'In_Time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Out_Time'); ?>
		<?php echo $form->textField($model,'Out_Time'); ?>
		<?php echo $form->error($model,'Out_Time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Mileage'); ?>
		<?php echo $form->textField($model,'Mileage'); ?>
		<?php echo $form->error($model,'Mileage'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'No_of_Pessengers'); ?>
		<?php echo $form->textField($model,'No_of_Pessengers'); ?>
		<?php echo $form->error($model,'No_of_Pessengers'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->