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

	<div class="row" style="display:none">
		<?php echo $form->label($model,'Insurance_ID'); ?>
		<?php echo $form->textField($model,'Insurance_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Vehicle_No'); ?>
		<?php echo $form->textField($model,'Vehicle_No',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Insurance_Company_ID'); ?>
		<?php echo $form->textField($model,'Insurance_Company_ID',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'Insurance_Type_ID'); ?>
		<?php echo $form->textField($model,'Insurance_Type_ID',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'Amount'); ?>
		<?php echo $form->textField($model,'Amount',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row"  style="display:none">
		<?php echo $form->label($model,'Date_of_Insurance'); ?>
		<?php echo $form->textField($model,'Date_of_Insurance'); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'Valid_From'); ?>
		<?php echo $form->textField($model,'Valid_From'); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'Valid_To'); ?>
		<?php echo $form->textField($model,'Valid_To'); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'add_by'); ?>
		<?php echo $form->textField($model,'add_by',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'add_date'); ?>
		<?php echo $form->textField($model,'add_date'); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'edit_by'); ?>
		<?php echo $form->textField($model,'edit_by',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'edit_date'); ?>
		<?php echo $form->textField($model,'edit_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->