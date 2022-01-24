<style>

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

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'Estimate_ID'); ?>
		<?php echo $form->textField($model,'Estimate_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Accident_ID'); ?>
		<?php echo $form->textField($model,'Accident_ID'); ?>
	</div>

	<!--<div class="row">
		<?php /*echo $form->label($model,'Damage_Estimate'); ?>
		<?php echo $form->textField($model,'Damage_Estimate',array('size'=>20,'maxlength'=>150));*/ ?>
	</div>

	<div class="row">
		<?php /* echo $form->label($model,'Estimated_Date'); ?>
		<?php echo $form->textField($model,'Estimated_Date');*/ ?>
	</div>-->

	<?php /*?><div class="row">
		<?php echo $form->label($model,'Description'); ?>
		<?php echo $form->textArea($model,'Description',array('rows'=>6, 'cols'=>50)); ?>
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

	<div class="row buttons" style="margin-left:500px">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->