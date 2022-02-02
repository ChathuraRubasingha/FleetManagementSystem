

<div class="form" id="MaDesignationDialogForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-designation-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true, 
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<table width="550">
	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Designation'); ?>
        </td><td>
		<?php echo $form->textField($model,'Designation',array('size'=>30,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Designation'); ?>
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
			$('#closeMaDesignationDialog').click(function()
			{
				//$('#MaDesignation_Designation').focus();
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('MaDesignation','Create'),Yii::app()->request->baseUrl."/index.php?r=maDesignation/addNew",                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			 $("#User_Designation_ID").append(data);
             $("#MaDesignationDialog").dialog("close");
                       			                       
		}                         
		else
		{                        
			   $("#MaDesignationDialog").dialog("close");                   
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaDesignationDialog')); 
	 
	 ?>
     
     
     
		<?php /*echo CHtml::ajaxSubmitButton(Yii::t('VehicleCategory','Create'),CHtml::normalizeUrl(array('VehicleCategory/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#MaVehicleRegistry_Vehicle_Category_ID").append(data);
                        $("#VehicleCategoryDialog").dialog("close");
                    }'),array('id'=>'closeVehicleCategoryDialog'));*/ ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->