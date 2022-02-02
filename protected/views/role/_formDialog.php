

<div class="form" id="RoleDialogForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'role-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true, 
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    <table width="550">

	<div class="row">
    <tr><td style="width:150px">
		<?php echo $form->labelEx($model,'Role'); ?>
        </td><td>
		<?php echo $form->textField($model,'Role',array('size'=>30,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Role'); ?>
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
			$('#closeRoleDialog').click(function()
			{
				//$('#Role_Role').focus();
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('Role','Create'),Yii::app()->request->baseUrl."/index.php?r=role/addNew",                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			 $("#User_Role_ID").append(data);
             $("#RoleDialog").dialog("close");
                       			                       
		}                         
		else
		{                        
			   $("#RoleDialog").dialog("close");                   
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeRoleDialog')); 
	 
	 ?>
     
     
     
		<?php /*echo CHtml::ajaxSubmitButton(Yii::t('VehicleCategory','Create'),CHtml::normalizeUrl(array('VehicleCategory/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#MaVehicleRegistry_Vehicle_Category_ID").append(data);
                        $("#VehicleCategoryDialog").dialog("close");
                    }'),array('id'=>'closeVehicleCategoryDialog'));*/ ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->