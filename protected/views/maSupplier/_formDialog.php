
<div class="form" id="MaSupplierDialogForm">


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-supplier-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true, 
)); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<table width="550" style="margin-left:15px;">
	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Supplier_Name'); ?>
        </td><td>
		<?php echo $form->textField($model,'Supplier_Name',array('size'=>50,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Supplier_Name'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Address'); ?>
        </td><td>
		<?php echo $form->textField($model,'Address',array('size'=>50,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'Address'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Contact_Person'); ?>
        </td><td>
		<?php echo $form->textField($model,'Contact_Person',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'Contact_Person'); ?>
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
		<?php echo $form->labelEx($model,'Email'); ?>
        </td><td>
		<?php echo $form->textField($model,'Email',array('size'=>50,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'Email'); ?>
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
			$('#closeMaSupplierDialog').click(function()
			{
				$('#MaSupplier_Supplier_Name').focus();
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('MaSupplier','Create'),CHtml::normalizeUrl(array('MaSupplier/addNew','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			$("#MaSupplierCategory_Supplier_ID").append(data);
			$("#MaSupplierDialog").dialog("close");              			                       
		}                         
		else
		{                        
			                    
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaSupplierDialog')); 
	 
	 ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->