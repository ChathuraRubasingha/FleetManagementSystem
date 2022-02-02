
<div class="form" id="MaReplacementOfServiceDialogForm">


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-replacement-of-service-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true, 
)); ?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<table width="550" border="1">
	<div class="row">
   		 <tr><td>
		<?php echo $form->labelEx($model,'Service_Replacement'); ?>
        </td><td>
		<?php echo $form->textField($model,'Service_Replacement',array('size'=>30,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Service_Replacement'); ?>
        </td></tr>
	</div>
    </table>

	
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
    
    
	<div class="row buttons" style="margin-left:75%;">
		<?php
        Yii::app()->getClientScript()->registerScript("validate", "
		$(document).ready(function()
		{
			$('#closeMaReplacementOfServiceDialog').click(function()
			{
				$('#MaReplacementOfService_Service_Replacement').focus();
				
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('MaReplacementOfService','Create'),CHtml::normalizeUrl(array('MaReplacementOfService/addNew&id=1','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {
		  if(status=="success")
		  {
			  $("#replacement-grid").append(data);
			  $("#replacement-grid").yiiGridView.update("replacement-grid");
			  $("#MaReplacementOfServiceDialog").dialog("close");
			
		}                         
		else
		{                        
			                
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaReplacementOfServiceDialog')); 
	 
	 ?>
	
		<?php /*echo CHtml::ajaxSubmitButton(Yii::t('MaReplacementOfService','Create'),CHtml::normalizeUrl(array('MaReplacementOfService/addNew','render'=>false)),array('success'=>'js: function(data) {
				$("#approve-grid").append(data);
				$("#approve-grid").yiiGridView.update("approve-grid"); 	   
 $("#MaReplacementOfServiceDialog").dialog("close");
                    }'),array('id'=>'closeMaReplacementOfServiceDialog'));*/ ?>

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->