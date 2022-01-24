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
		<?php echo $form->label($model,'Repair_Details_ID'); ?>
		<?php echo $form->textField($model,'Repair_Details_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Repairs_ID'); ?>
		<?php echo $form->textField($model,'Repairs_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Description'); ?>
		<?php echo $form->textField($model,'Description',array('size'=>60,'maxlength'=>255)); ?>
	</div><?php */?>

	<div class="row">
		<?php echo $form->label($model,'Replacement_ID'); ?>
		<?php echo $form->dropDownList($model, 'Replacement_ID', CHtml::listData(
   MaReplacement::model()->findAll(), 'Replacement_ID', 'Replacement'),array('prompt' => 'Please Select'));   ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Supplier_ID'); ?>
		      <?php echo $form->dropDownList($model, 'Supplier_ID', CHtml::listData(
   MaSupplier::model()->findAll(), 'Supplier_ID', 'Supplier_Name'),array('prompt' => 'Please Select'));   ?>
	</div>

	<?php /*?><div class="row">
		<?php echo $form->label($model,'Approved_By'); ?>
		<?php echo $form->textField($model,'Approved_By',array('size'=>60,'maxlength'=>100)); ?>
	</div><?php */?>

	

	<div class="row buttons" style="margin-left:500px">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->