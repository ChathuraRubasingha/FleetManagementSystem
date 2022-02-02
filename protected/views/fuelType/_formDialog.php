<div class="form" id="FuelTypeDialogForm">
 

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'fuel-type-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true, 
'htmlOptions'=>array('style'=>'height:120px;'),
));  
$curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");

?>


	<?php echo $form->errorSummary($model); ?>
	<table width="100%" >
            <div class="row">
 		<tr>
                    <td width="150px"><?php echo $form->labelEx($model,'Fuel_Type'); ?></td>
                    <td><?php echo $form->textField($model,'Fuel_Type',array('size'=>30,'maxlength'=>200)); ?>
                        <?php echo $form->error($model,'Fuel_Type'); ?></td>
                </tr>
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
		echo $form->hiddenField($model,'add_date',array('value'=>$curDateTime));
		} else {
		echo $form->hiddenField($model,'add_date',array());	
		}
		?>
	</div>
    
  
</table>
	<div class="row buttons" style="margin-left:65%;">
    
    <?php
        Yii::app()->getClientScript()->registerScript("validate", "
		$(document).ready(function()
		{
			$('#closeFuelTypeDialog').click(function()
			{
				$('#FuelType_Fuel_Type').focus();
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('FuelType','Create'),CHtml::normalizeUrl(array('fuelType/addNew','render'=>false)), array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {             
	  	                         
		if(	status=="success")
		{    
			$("#MaVehicleRegistry_Fuel_Type_ID").append(data);
			$("#TRFuelProvidingDetails_Fuel_Type_ID").append(data);
            //$("#FuelTypeDialog").dialog("close");
                       			                       
		}                         
		else
		{                        
			              
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeFuelTypeDialog')); 
	 
	 ?>
    
<?php /*echo CHtml::ajaxSubmitButton(Yii::t('FuelType','Create'),CHtml::normalizeUrl(array('fuelType/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#MaVehicleRegistry_Fuel_Type_ID").append(data);
                        $("#FuelTypeDialog").dialog("close");
                    }'),array('id'=>'closeFuelTypeDialog'));*/ ?>	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->