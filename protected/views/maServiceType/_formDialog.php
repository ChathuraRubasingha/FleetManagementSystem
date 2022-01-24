
<div class="form" id="MaServiceTypeDialogForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-service-type-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<table width="550" border="1">
	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Service_Type'); ?>
        </td><td>
		<?php echo $form->textField($model,'Service_Type',array('size'=>30,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Service_Type'); ?>
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

	<div class="row buttons" style="margin-left:68%;">
		<?php
        Yii::app()->getClientScript()->registerScript("validate", "
		$(document).ready(function()
		{
			$('#closeMaLocationDialog').click(function()
			{
				$('#MaServiceType_Service_Type').focus();
				
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('MaServiceType','Create'),CHtml::normalizeUrl(array('MaServiceType/addNew','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			$("#TRServices_Service_Type_ID").append(data);
            $("#MaServiceTypeDialog").dialog("close");
                       			                       
		}                         
		else
		{                        
			                
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaLocationDialog')); 
	 
	 ?>
		<?php /*echo CHtml::ajaxSubmitButton(Yii::t('MaServiceType','Create'),CHtml::normalizeUrl(array('MaServiceType/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#TRServices_Service_Type_ID").append(data);
                        $("#MaServiceTypeDialog").dialog("close");
                    }'),array('id'=>'closeMaServiceTypeDialog'));*/ ?>

	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->