<style>

td
{
	padding:0;
}

input[type=text], input[type=password]
{

  -webkit-border-radius: 5px;
  -webkit-padding-end: 20px;
  -webkit-padding-start: 2px;
  border-radius:5px;
 box-shadow: inset 0 10px 10px #DAF0FD;
  background-position: center right;
  background-repeat: no-repeat;
   border:#2c343c 1px solid;
  color: #555;
  font-size: inherit;
  margin: 0;
  padding-top: 2px;
  padding-bottom: 2px;

}

select  {
  outline: 0;
  overflow: hidden;
  height: 25px;
  box-shadow: inset 0 10px 10px #DAF0FD;
  color:#000000;
  border:#2c343c 1px solid;
  padding:0;
  -moz-border-radius:6px;
 -webkit-border-radius:6px;
 border-radius:5px;
}


</style>


<div class="form" id="MaInsuranceTypeDialogForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-insurance-type-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true, 
)); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<table width="550" border="1">
	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Insurance_Type'); ?>
        </td><td>
		<?php echo $form->textField($model,'Insurance_Type',array('size'=>50,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Insurance_Type'); ?>
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
			$('#closeMaInsuranceTypeDialog').click(function()
			{
				$('#MaInsuranceType_Insurance_Type').focus();
				
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('MaInsuranceType','Create'),CHtml::normalizeUrl(array('MaInsuranceType/addNew','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			 $("#TRInsurance_Insurance_Type_ID").append(data);
             $("#MaInsuranceTypeDialog").dialog("close");
		}                         
		else
		{                        
			                
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaInsuranceTypeDialog')); 
	 
	 ?>
     
     
		<?php /*echo CHtml::ajaxSubmitButton(Yii::t('MaInsuranceType','Create'),CHtml::normalizeUrl(array('MaInsuranceType/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#TRInsurance_Insurance_Type_ID").append(data);
                        $("#MaInsuranceTypeDialog").dialog("close");
                    }'),array('id'=>'closeMaInsuranceTypeDialog'));*/ ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->