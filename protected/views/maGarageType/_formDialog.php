

<div class="form" id="MaGarageTypeDialogForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-garage-type-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
<table width="550" border="1">
	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Garage_Type'); ?>
        </td><td>
		<?php echo $form->textField($model,'Garage_Type',array('size'=>30,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Garage_Type'); ?>
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

	<div class="row buttons" style="margin-left:67%;">
		<?php echo CHtml::ajaxSubmitButton(Yii::t('MaGarageType','Create'),CHtml::normalizeUrl(array('MaGarageType/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#MaGarages_Garage_Type_ID").append(data);
                        $("#MaGarageTypeDialog").dialog("close");
                    }'),array('id'=>'closeMaGarageTypeDialog')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->