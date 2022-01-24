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

	<?php /*?><div class="row">
		<?php echo $form->label($model,'Booking_Request_ID'); ?>
		<?php echo $form->textField($model,'Booking_Request_ID'); ?>
	</div><?php */?>

	<div class="row">
		<?php echo $form->label($model,'User_ID'); ?>
		<?php echo $form->textField($model,'User_ID'); ?>
	</div>

	<?php /*?><div class="row">
		<?php echo $form->label($model,'Vehicle_Category_ID'); ?>
		<?php echo $form->textField($model,'Vehicle_Category_ID'); ?>
	</div><?php */?>

	<div class="row">
		<?php echo $form->label($model,'Vehicle_No'); ?>
		<?php echo $form->textField($model,'Vehicle_No',array('size'=>20,'maxlength'=>20)); ?>
	</div>
<div class="row buttons" style="margin-left:66%">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
	<!--<div class="row">
		<?php /*echo $form->label($model,'Driver_ID'); ?>
		<?php echo $form->textField($model,'Driver_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'From'); ?>
		<?php echo $form->textField($model,'From'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'To'); ?>
		<?php echo $form->textField($model,'To'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'No_of_Passengers'); ?>
		<?php echo $form->textField($model,'No_of_Passengers'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Booking_Status'); ?>
		<?php echo $form->textField($model,'Booking_Status',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Allocation_Type_ID'); ?>
		<?php echo $form->textField($model,'Allocation_Type_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Description'); ?>
		<?php echo $form->textArea($model,'Description',array('rows'=>6, 'cols'=>50)); ?>
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
		<?php echo $form->label($model,'Requested_Date'); ?>
		<?php echo $form->textField($model,'Requested_Date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Approved_By'); ?>
		<?php echo $form->textField($model,'Approved_By',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Approved_Date'); ?>
		<?php echo $form->textField($model,'Approved_Date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'add_by'); ?>
		<?php echo $form->textField($model,'add_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'add_date'); ?>
		<?php echo $form->textField($model,'add_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'edit_by'); ?>
		<?php echo $form->textField($model,'edit_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'edit_date'); ?>
		<?php echo $form->textField($model,'edit_date');*/ ?>
	</div>-->

	