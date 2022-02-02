<div class="form" >
   

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'notification-configuration-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        <table width="550" border="1" >

            <div class="row" style="display: none;">
		<?php echo $form->labelEx($model,'Configuration_Name'); ?>
		<?php echo $form->textField($model,'Configuration_Name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'Configuration_Name'); ?>
	</div>
<?php
if($model->Row !== "4"){
?>
<tr>
        <div class="row">
            <td><?php echo $form->labelEx($model,'Description'); ?></td>
            <td><?php echo $form->textField($model,'Description',array('size'=>60,'maxlength'=>200, 'readOnly'=>true)); ?>
		<?php echo $form->error($model,'Description'); ?></td>
            
	</div>
</tr>
<tr>
	<div class="row">
		<td><?php echo $form->labelEx($model,'Value'); ?></td>
		<td><?php echo $form->textField($model,'Value'); ?>
		<?php echo $form->error($model,'Value'); ?></td>
	</div>
</tr>
</table>
<?php 
}
 else {
?>
<table width="550" border="1" >     
  <tr>
        <div class="row">
            <td><?php echo $form->labelEx($model,'Description'); ?></td>
            <td><?php echo $form->textField($model,'Description',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Description'); ?></td>
            
	</div>
</tr>  
  <tr>
	<div class="row">
		<td><?php echo $form->labelEx($model,'Value'); ?></td>
		<td><?php echo $form->dropDownList($model,'Value',array("1"=>"On","0"=>"Off"), array('prompt'=>"--- Please Select ---", 'class'=>'midSelect')); ?>
		<?php echo $form->error($model,'Value'); ?></td>
	</div>
</tr> 
</table>
<?php 

 }
?>        

	<div class="row buttons" style="padding-left:75%;font-weight:bold">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->