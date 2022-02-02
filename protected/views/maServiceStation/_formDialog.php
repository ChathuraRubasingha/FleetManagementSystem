
<div class="form" id="MaServiceStationDialogForm">

<?php /*$form=$this->beginWidget('CActiveForm', array(
	'id'=>'MaServiceStation-form',
	'enableAjaxValidation'=>true,
));*/ ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-service-station-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true, 
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    <table width="550" border="1">

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Srvice_Station_Name'); ?>
        </td><td>
		<?php echo $form->textField($model,'Srvice_Station_Name',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Srvice_Station_Name'); ?>
        </td></tr>
	</div>

	

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Land_phone_No'); ?>
        </td><td>
		<?php echo $form->textField($model,'Land_phone_No',array('size'=>20,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'Land_phone_No'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Mobile_No'); ?>
        </td><td>
		<?php echo $form->textField($model,'Mobile_No',array('size'=>20,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'Mobile_No'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Fax'); ?>
        </td><td>
		<?php echo $form->textField($model,'Fax',array('size'=>20,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'Fax'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Contact_Person'); ?>
        </td><td>
		<?php echo $form->textField($model,'Contact_Person',array('size'=>40,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'Contact_Person'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Registration_No'); ?>
        </td><td>
		<?php echo $form->textField($model,'Registration_No',array('size'=>40,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'Registration_No'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Owner_Name'); ?>
        </td><td>
		<?php echo $form->textField($model,'Owner_Name',array('size'=>40,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'Owner_Name'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Email'); ?>
        </td><td>
		<?php echo $form->textField($model,'Email',array('size'=>40,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'Email'); ?>
        </td></tr>
	</div>
    
    <div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Address'); ?>
        </td><td>
         <?php echo $form->textArea($model,'Address',array('rows'=>3, 'cols'=>40)); ?>
		<?php echo $form->error($model,'Address'); ?>
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
			$('#closeMaServiceStationDialog').click(function()
			{
				$('#MaServiceStation_Srvice_Station_Name').focus();
				$('#MaServiceStation_Address').focus();
				$('#MaServiceStation_Registration_No').focus();
				$('#MaServiceStation_Owner_Name').focus();
				$('#MaServiceStation_Email').focus();
				
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('MaServiceStation','Create'),CHtml::normalizeUrl(array('MaServiceStation/addNew','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			  $("#TRServices_Service_Station_ID").append(data);
              $("#MaServiceStationDialog").dialog("close");
                       			                       
		}                         
		else
		{                        
			                       
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaServiceStationDialog')); 
	 
	 ?>
     
     
		<?php /*echo CHtml::ajaxSubmitButton(Yii::t('MaServiceStation','Create'),CHtml::normalizeUrl(array('MaServiceStation/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#TRServices_Service_Station_ID").append(data);
                        $("#MaServiceStationDialog").dialog("close");
                    }'),array('id'=>'closeMaServiceStationDialog'));*/ ?>

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->