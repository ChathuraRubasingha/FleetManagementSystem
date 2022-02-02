
<div class="form" id="MaAllocationTypeDialogForm">
 
<?php 
$form=$this->beginWidget('CActiveForm', array(       
'id'=>'ma-allocation-type-form',       
'enableAjaxValidation'=>true,        
'enableClientValidation'=>true,        
//'clientOptions' => array(                
//'validateOnSubmit'=>true,                
//'validateOnChange'=>true,                
//'validateOnType'=>false,        ),        
//'htmlOptions' => array('enctype'=>'multipart/form-data'),
)

);


?>

	
   <table width="100%" >
	<div class="row">
 
    <tr><td width="150px">
		<?php echo $form->labelEx($model,'Allocation_Type'); ?>
        </td><td>
		<?php echo $form->textField($model,'Allocation_Type',array('size'=>30,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Allocation_Type'); ?>
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
 <?php
        Yii::app()->getClientScript()->registerScript("validate", "
		$(document).ready(function()
		{
			$('#closeMaAllocationTypeDialog').click(function()
			{
				$('#MaAllocationType_Allocation_Type').focus();
				//alert('ok');
			});
		});
		
		");
		?>
        
	<div class="row buttons" style="margin-left:65%;">
		
         <?php echo CHtml::ajaxSubmitButton(Yii::t('MaAllocationType','Create'),CHtml::normalizeUrl(array('maAllocationType/addNew','render'=>false)), array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			 $("#MaVehicleRegistry_Allocation_Type_ID").append(data);
			 isAddNew = true;
			
             $("#MaAllocationTypeDialog").dialog("close");  
			 isAddNew = false;			                       
		}                         
		else
		{                        
			   isAddNew = false;                   
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaAllocationTypeDialog')); 
	 
	 ?>
        
        
		<?php /*echo CHtml::ajaxSubmitButton(Yii::t('MaAllocationType','Create'),CHtml::normalizeUrl(array('MaAllocationType/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#MaVehicleRegistry_Allocation_Type_ID").append(data);
                        $("#MaAllocationTypeDialog").dialog("close");
                    }'),array('id'=>'closeMaAllocationTypeDialog'));*/ ?>

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->