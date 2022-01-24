

<div class="form" id="VehicleStatusDialogForm">

<?php /*$form=$this->beginWidget('CActiveForm', array(
	'id'=>'vehicle-status-form',
	'enableAjaxValidation'=>false,
));*/ ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vehicle-status-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true, 
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    <table width="550">

	<div class="row">
 		<tr><td width="150px">
   
		<?php echo $form->labelEx($model,'Vehicle_Status'); ?>
        </td><td>
        
		<?php echo $form->textField($model,'Vehicle_Status',array('size'=>30,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Vehicle_Status'); ?>
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
			$('#closeVehicleStatusDialog').click(function()
			{
				$('#VehicleStatus_Vehicle_Status').focus();
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('VehicleStatus','Create'),CHtml::normalizeUrl(array('vehicleStatus/addNew','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			$("#MaVehicleRegistry_Vehicle_Status_ID").append(data);
            $("#VehicleStatusDialog").dialog("close");
                       			                       
		}                         
		else
		{                        
			                
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeVehicleStatusDialog')); 
	 
	 ?>
     	
		<?php /*echo CHtml::ajaxSubmitButton(Yii::t('vehicleStatus','Create'),CHtml::normalizeUrl(array('VehicleStatus/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#MaVehicleRegistry_Vehicle_Status_ID").append(data);
                        $("#VehicleStatusDialog").dialog("close");
                    }'),array('id'=>'closeVehicleStatusDialog'));*/ ?>

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->