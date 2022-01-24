
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'repair-details-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<table width="550" >
	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Repairs_ID'); ?>
        </td><td>
        <?php echo $form->dropdownlist($model,'Repairs_ID',CHtml::listData(MaRepairs::model()->findAll(),'Repairs_ID','Repairs_ID'),array('empty'=>'--please select--', 'class'=>'midSelect'));  ?>
		<?php /*echo $form->textField($model,'Repairs_ID'); */?>
		<?php echo $form->error($model,'Repairs_ID'); ?>
        </td></tr>
	</div>
    
    <div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Replacement_ID'); ?>
        </td><td>
        <?php echo $form->dropdownlist($model,'Replacement_ID',CHtml::listData(MaReplacement::model()->findAll(),'Replacement_ID','Replacement'),array('empty'=>'--please select--', 'class'=>'midSelect'));  ?>
		<?php /*echo $form->textField($model,'Replacement_ID'); */?>
		<?php echo $form->error($model,'Replacement_ID'); ?>
        </td></tr>
	</div>
    
     <div class="row">
     <tr><td>
		<?php echo $form->labelEx($model,'Supplier_ID'); ?>
        </td><td>
        <?php echo $form->dropdownlist($model,'Supplier_ID',CHtml::listData(MaSupplier::model()->findAll(),'Supplier_ID','Supplier_Name'),array('empty'=>'--please select--'));  ?>
		<?php /*echo $form->textField($model,'Replacement_ID'); */?>
		<?php echo $form->error($model,'Replacement_ID'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Description'); ?>
        </td><td>
		<?php echo $form->textField($model,'Description',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Description'); ?>
        </td></tr>
	</div>

	

	<div class="row" >
    <tr style="display:none"><td>
		<?php echo $form->labelEx($model,'Approved_By'); ?>
        </td><td>
		<?php echo $form->textField($model,'Approved_By',array('size'=>60,'maxlength'=>100));?>
		<?php echo $form->error($model,'Approved_By'); ?>
        </td></tr>
	</div>

	<?php date_default_timezone_set('Asia/Colombo'); ?>
	<div class="row">
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));
		}
		else {
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50));	
		}
		 ?>
	</div>

	<div class="row">
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_date',array('value'=>date("Y-m-d : H:i:s", time())));
		} else {
		echo $form->hiddenField($model,'add_date',array());	
		}
		?>
	</div>
    
   <div class="row">
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>'Not Edited'));
		} else {
		echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));   	
		}
		?>
	</div>

	<div class="row">
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'edit_date',array('value'=>'Not Edited'));
		} else {
		echo $form->hiddenField($model,'edit_date',array('value'=>date("Y-m-d : H:i:s", time())));	
		}
		?>
	</div>
    </table>

	<div class="row" style="padding-left:37%;font-weight:bold">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save');?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->