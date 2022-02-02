

<div class="form" id="MaTyreTypeDialogForm">
 
<?php /*$form=$this->beginWidget('CActiveForm', array(
    'id'=>'MaTyreType-form',
    'enableAjaxValidation'=>true,
)); */
//I have enableAjaxValidation set to true so i can validate on the fly the
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-tyre-type-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true, 
)); ?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    <table width="550">

	<div class="row">
 		<tr><td width="150px">
		<?php echo $form->labelEx($model,'Tyre_Type'); ?>
        </td><td>
		<?php echo $form->textField($model,'Tyre_Type',array('size'=>30,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'Tyre_Type'); ?>
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
			$('#closeMaTyreTypeDialog').click(function()
			{
				$('#MaTyreType_Tyre_Type').focus();
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('MaTyreType','Create'),CHtml::normalizeUrl(array('MaTyreType/addNew','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			$("#MaVehicleRegistry_Tyre_Type_ID").append(data);
            $("#MaTyreTypeDialog").dialog("close");
                       			                       
		}                         
		else
		{                        
			                       
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaTyreTypeDialog')); 
	 
	 ?>
     
<?php /*echo CHtml::ajaxSubmitButton(Yii::t('MaTyreType','Create'),CHtml::normalizeUrl(array('MaTyreType/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#MaVehicleRegistry_Tyre_Type_ID").append(data);
                        $("#MaTyreTypeDialog").dialog("close");
                    }'),array('id'=>'closeMaTyreTypeDialog'));*/ ?>	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->