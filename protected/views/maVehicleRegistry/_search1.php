

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php /*?><div class="row">
		<?php echo $form->label($model,'Accident_ID'); ?>
		<?php echo $form->textField($model,'Accident_ID'); ?>
	</div><?php */?>

	<div class="row">
		<?php echo $form->label($model,'Vehicle_No'); ?>
		<?php #echo $form->textField($model,'Vehicle_No',array('size'=>20,'maxlength'=>20)); ?>
        <?php echo $form->dropDownList($model,'Vehicle_No',CHtml::listData(MaVehicleRegistry::model()->findAllVehicles(),'Vehicle_No','Vehicle_No'),array( 'empty'=>'--- Please Select ---','class'=>'midSelect')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Accident_Place'); ?>
		<?php echo $form->textField($model,'Accident_Place',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Date_and_Time'); ?>
		<?php echo $form->textField($model,'Date_and_Time'); ?>
	</div>

	<?php /*?>div class="row">
		<?php echo $form->label($model,'Details'); ?>
		<?php echo $form->textField($model,'Details',array('size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Police_Station'); ?>
		<?php echo $form->textField($model,'Police_Station',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Address'); ?>
		<?php echo $form->textField($model,'Address',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Driver_ID'); ?>
		<?php echo $form->textField($model,'Driver_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Police_Report_No'); ?>
		<?php echo $form->textField($model,'Police_Report_No',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Accident_Type'); ?>
		<?php echo $form->textField($model,'Accident_Type',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'add_by'); ?>
		<?php echo $form->textField($model,'add_by',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'add_date'); ?>
		<?php echo $form->textField($model,'add_date',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'edit_by'); ?>
		<?php echo $form->textField($model,'edit_by',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'edit_date'); ?>
		<?php echo $form->textField($model,'edit_date',array('size'=>50,'maxlength'=>50)); ?>
	</div><?php */?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->