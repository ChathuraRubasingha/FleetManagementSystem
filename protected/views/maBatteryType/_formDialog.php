

<div class="form" id="MaBatteryTypeDialogForm">

<?php /*$form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-battery-type-form',
	'enableAjaxValidation'=>false,
));*/ ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-battery-type-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true, 
)); ?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
 	<table width="550" >
	<div class="row">
 		<tr><td width="150px">
		<?php echo $form->labelEx($model,'Battery_Type'); ?>
        </td><td>
		<?php echo $form->textField($model,'Battery_Type',array('size'=>30,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'Battery_Type'); ?>
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
		 <?php
        Yii::app()->getClientScript()->registerScript("validate", "
		$(document).ready(function()
		{
			$('#closeMaBatteryTypeDialog').click(function()
			{
				$('#MaBatteryType_Battery_Type').focus();
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('MaBatteryType','Create'),CHtml::normalizeUrl(array('MaBatteryType/addNew','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			$("#MaVehicleRegistry_Battery_Type_ID").append(data);
            $("#MaBatteryTypeDialog").dialog("close");               			                       
		}                         
		else
		{                        
			                       
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaBatteryTypeDialog')); 
	 
	 ?>
		<?php /*echo CHtml::ajaxSubmitButton(Yii::t('MaBatteryType','Create'),CHtml::normalizeUrl(array('MaBatteryType/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#MaVehicleRegistry_Battery_Type_ID").append(data);
                        $("#MaBatteryTypeDialog").dialog("close");
                    }'),array('id'=>'closeMaBatteryTypeDialog'));*/ ?>

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->