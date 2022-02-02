

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'access-control-actions-form',
	'enableAjaxValidation'=>false,
)); ?>

	<!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->
 
    <div  style="width:900px; float:left; ">
        <div class="group" style="width:89%; margin-left:32.6%; float:left; margin-top:-24.3%">
<h1 style="margin-bottom:5%;">Update Action Details</h1>
	<?php echo $form->errorSummary($model); ?>
<table width="550" style="margin-left:20px;">
	<div class="row">
    <tr>
    	<td style="width:200px;"><?php echo $form->labelEx($model,'action_name'); ?></td>
        <td><?php echo $form->textField($model,'action_name',array('size'=>30,'maxlength'=>100,'disabled'=>true)); ?>
			<?php echo $form->error($model,'action_name'); ?></td>
    </tr>
	</div>
    
    <div class="row">
    <tr>
    	<td><?php echo $form->labelEx($model,'Action_Display_Name'); ?></td>
        <td><?php echo $form->textField($model,'Action_Display_Name',array('size'=>30,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'Action_Display_Name'); ?></td>
    </tr>
	</div>


	<div class="row" style="display:none">
		<?php echo $form->labelEx($model,'controller_Id'); ?>
		<?php echo $form->textField($model,'controller_Id'); ?>
		<?php echo $form->error($model,'controller_Id'); ?>
	</div>
 </table>
	<div class="row" style="padding-left:37%;font-weight:bold">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save');?>
</div>
   
</div>
<?php $this->endWidget(); ?>

</div><!-- form --></div>