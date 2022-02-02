<div class="form" id="MaBranchDialogForm">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-branch-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true, 
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<table width="550" >
	<div class="row">
    <tr>
    	<td><?php echo $form->labelEx($model,'Branch'); ?></td>
        <td><?php echo $form->textField($model,'Branch',array('size'=>30,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'Branch'); ?></td>
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
			$('#closeMaBranchDialog').click(function()
			{
				$('#MaBranch_Branch').focus();
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('MaDesignation','Create'),Yii::app()->request->baseUrl."/index.php?r=maBranch/addNew",                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			$("#User_Branch_Id").append(data);
            $("#MaBranchDialog").dialog("close");               			                       
		}                         
		else
		{                        
			                       
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaBranchDialog')); 
	 
	 ?>
		<?php /*echo CHtml::ajaxSubmitButton(Yii::t('MaBatteryType','Create'),CHtml::normalizeUrl(array('MaBatteryType/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#MaVehicleRegistry_Battery_Type_ID").append(data);
                        $("#MaBatteryTypeDialog").dialog("close");
                    }'),array('id'=>'closeMaBatteryTypeDialog'));*/ ?>

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->