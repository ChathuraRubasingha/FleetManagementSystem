<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pizza-type-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'pizza_type'); ?>
		<?php echo $form->textField($model,'pizza_type',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'pizza_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pizza_price'); ?>
		<?php echo $form->textField($model,'pizza_price'); ?>
		<?php echo $form->error($model,'pizza_price'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->