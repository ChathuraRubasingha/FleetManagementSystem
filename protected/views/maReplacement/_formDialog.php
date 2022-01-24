

<div class="form" id="MaReplacementDialogForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-replacement-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true, 
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
<table width="550" border="1">
	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Replacement'); ?>
        </td><td>
		<?php echo $form->textField($model,'Replacement',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'Replacement'); ?>
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

	<div class="row buttons" style="margin-left:80%;">
    
     <?php
        Yii::app()->getClientScript()->registerScript("validate", "
		$(document).ready(function()
		{
			$('#closeMaReplacementDialog').click(function()
			{
				//$('#MaReplacement_Replacement').focus();
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('MaReplacement','Create'),CHtml::normalizeUrl(array('MaReplacement/addNew','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			$("#MaSupplierCategory_Replacement_ID").append(data);
			$("#MaReplacementDialog").dialog("close");              			                       
		}                         
		else
		{                        
			                    
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaReplacementDialog')); 
	 
	 ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->