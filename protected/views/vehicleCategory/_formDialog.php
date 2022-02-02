<div class="form" id="VehicleCategoryDialogForm">
 


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vehicle-category-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true, 
'htmlOptions'=>array('style'=>'height:120px;'),
)); ?>


	

	<?php echo $form->errorSummary($model); ?>
	<table width="100%" >
	<div class="row">
            <tr>
                <td width="150px">
                    <?php echo $form->labelEx($model,'Category_Name'); ?></td>
                <td><?php echo $form->textField($model,'Category_Name',array('size'=>20,'maxlength'=>200)); ?>
                    <?php echo $form->error($model,'Category_Name'); ?></td>
            </tr>
	</div>

	<?php date_default_timezone_set('Asia/Colombo'); ?>
            <div class="row" style="display: none">
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));
		}
		else {
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50));	
		}
		 ?>
	</div>

            <div class="row" style="display: none">
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_date',array('value'=>date("Y-m-d : H:i:s", time())));
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
			$('#closeVehicleCategoryDialog').click(function()
			{
				$('#VehicleCategory_Category_Name').focus();
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('VehicleCategory','Create'),CHtml::normalizeUrl(array('VehicleCategory/addNew','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			 $("#MaVehicleRegistry_Vehicle_Category_ID").append(data);
             $("#VehicleCategoryDialog").dialog("close");
                       			                       
		}                         
		else
		{                        
			                      
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeVehicleCategoryDialog')); 
	 
	 ?>
     
     
     
		<?php /*echo CHtml::ajaxSubmitButton(Yii::t('VehicleCategory','Create'),CHtml::normalizeUrl(array('VehicleCategory/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#MaVehicleRegistry_Vehicle_Category_ID").append(data);
                        $("#VehicleCategoryDialog").dialog("close");
                    }'),array('id'=>'closeVehicleCategoryDialog'));*/ ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->