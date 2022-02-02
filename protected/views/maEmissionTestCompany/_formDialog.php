

<div class="form" id="MaEmissionTestCompanyDialogForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-emission-test-company-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<table width="550" border="1" >
	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Company_Name'); ?>
        </td><td>
		<?php echo $form->textField($model,'Company_Name',array('size'=>50,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Company_Name'); ?>
        </td></tr>
	</div>


    
    <div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Contact_Person'); ?>
        </td><td>
		<?php echo $form->textField($model,'Contact_Person',array('size'=>50,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'Contact_Person'); ?>
        </td></tr>
	</div>
	
    <div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Email'); ?>
        </td><td>
		<?php echo $form->textField($model,'Email',array('size'=>50,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'Email'); ?>
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
		<?php echo $form->labelEx($model,'Mobile'); ?>
        </td><td>
		<?php echo $form->textField($model,'Mobile',array('size'=>20,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'Mobile'); ?>
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
		<?php echo $form->textField($model,'Owner_Name',array('size'=>40,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'Owner_Name'); ?>
        </td></tr>
	</div>
	
    <div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Address'); ?>
        </td><td>
         <?php echo $form->textArea($model,'Address',array('rows'=>6, 'cols'=>56)); ?>
		<?php #echo $form->textField($model,'Address',array('size'=>60,'maxlength'=>255)); ?>
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
			$('#closeMaEmissionTestCompanyDialog').click(function()
			{
				$('#MaEmissionTestCompany_Company_Name').focus();
				$('#MaEmissionTestCompany_Address').focus();
				$('#MaEmissionTestCompany_Registration_No').focus();
				$('#MaEmissionTestCompany_Owner_Name').focus();
				$('#MaEmissionTestCompany_Fax').focus();
				
				
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('MaEmissionTestCompany','Create'),CHtml::normalizeUrl(array('MaEmissionTestCompany/addNew','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			 $("#TREmissionTest_Emission_Test_Company_ID").append(data);
             $("#MaEmissionTestCompanyDialog").dialog("close");
		}                         
		else
		{                        
			                
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaEmissionTestCompanyDialog')); 
	 
	 ?>
     
      
		<?php /*echo CHtml::ajaxSubmitButton(Yii::t('MaEmissionTestCompany','Create'),CHtml::normalizeUrl(array('MaEmissionTestCompany/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#TREmissionTest_Emission_Test_Company_ID").append(data);
                        $("#MaEmissionTestCompanyDialog").dialog("close");
                    }'),array('id'=>'closeMaEmissionTestCompanyDialog'));*/ ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->