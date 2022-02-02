

<div class="form" id="MaGaragesDialogForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-garages-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
<table width="550" border="1">
	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Garage_Type_ID'); ?>
        </td>
        
       <td>
            <div id="MaGarageType">
                <?php echo $form->dropDownList($model,'Garage_Type_ID',CHtml::listData(MaGarageType::model()->findAll(),'Garage_Type_ID','Garage_Type'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
                <?php echo CHtml::ajaxButton(Yii::t('MaGarageType',' '),$this->createUrl('MaGarageType/addNew'),array(
                'onclick'=>'if (MaGarageTypeAjaxComplete) { $("#MaGarageTypeDialog").dialog("open"); return false; } else { MaGarageTypeAjaxComplete = true; }',
                'update'=>'#MaGarageTypeDialog'
                ),array('id'=>'showMaGarageTypeDialog', 'class'=>'addBtn', 'title'=>'Add New Item'));?>
                <div id="MaGarageTypeDialog"></div>
                
            </div>
            <?php echo $form->error($model,'Garage_Type_ID'); ?>
        </td> 
        </tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Garage_Name'); ?>
        </td><td>
		<?php echo $form->textField($model,'Garage_Name',array('size'=>50,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Garage_Name'); ?>
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
		<?php echo $form->labelEx($model,'Registration_No'); ?>
        </td><td>
		<?php echo $form->textField($model,'Registration_No',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'Registration_No'); ?>
        </td></tr>
	</div>
    
    <div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Owner_Name'); ?>
        </td><td>
		<?php echo $form->textField($model,'Owner_Name',array('size'=>50,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Owner_Name'); ?>
        </td></tr>
	</div>


	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Land_Phone_No'); ?>
        </td><td>
		<?php echo $form->textField($model,'Land_Phone_No',array('size'=>20,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'Land_Phone_No'); ?>
        </td></tr>
	</div>

	<div class="row" style="display:none">
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
		<?php echo $form->labelEx($model,'Contact_No'); ?>
        </td><td>
		<?php echo $form->textField($model,'Contact_No',array('size'=>20,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'Contact_No'); ?>
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
			$('#closeMaGaragesDialog').click(function()
			{
				$('#MaGarages_Garage_Type_ID').focus();
				$('#MaGarages_Garage_Name').focus();
				$('#MaGarages_Registration_No').focus();
				$('#MaGarages_Owner_Name').focus();
				$('#MaGarages_Land_Phone_No').focus();
				
				
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('MaGarages','Create'),CHtml::normalizeUrl(array('MaGarages/addNew','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			 $("#TRFitnessTest_Garage_ID").append(data);
			$("#TRRepairEstimateDetails_Garage_ID").append(data);
			$("#MaGaragesDialog").dialog("close");
		}                         
		else
		{                        
			                
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaGaragesDialog')); 
	 
	 ?>
     
     
		<?php /*echo CHtml::ajaxSubmitButton(Yii::t('MaGarages','Create'),CHtml::normalizeUrl(array('MaGarages/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#TRFitnessTest_Garage_ID").append(data);
						$("#TRRepairEstimateDetails_Garage_ID").append(data);
                        $("#MaGaragesDialog").dialog("close");
                    }'),array('id'=>'closeMaGaragesDialog'));*/ ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->