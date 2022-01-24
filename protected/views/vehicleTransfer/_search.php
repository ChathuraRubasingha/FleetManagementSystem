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
		<?php echo $form->label($model,'VehicleTransfer_ID'); ?>
		<?php echo $form->textField($model,'VehicleTransfer_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Vehicle_No'); ?>
		<?php echo $form->textField($model,'Vehicle_No',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'From_Location_ID'); ?>
		<?php echo $form->textField($model,'From_Location_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'To_Location_ID'); ?>
		<?php echo $form->textField($model,'To_Location_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'From_Date'); ?>
		<?php echo $form->textField($model,'From_Date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'To_Date'); ?>
		<?php echo $form->textField($model,'To_Date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->