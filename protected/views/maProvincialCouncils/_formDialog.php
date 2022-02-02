


<?php
/* @var $this MaProvincialCouncilsController */
/* @var $model MaProvincialCouncils */
/* @var $form CActiveForm */
?>

<div class="form" id="MaProvincialCouncilsDialogForm">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-provincial-councils-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true, 
)); ?>
<?php /*$form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-provincial-councils-form',
	'enableAjaxValidation'=>false,
));*/ ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<table width="550">
    
	<div class="row">
 		<tr><td width="160px">
		<?php echo $form->labelEx($model,'Provincial Council'); ?>
        </td><td>
		<?php echo $form->textField($model,'Provincial_Councils_Name',array('size'=>30,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'Provincial_Councils_Name'); ?>
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
			$('#closeMaProvincialCouncilsDialog').click(function()
			{
				$('#MaProvincialCouncils_Provincial_Councils_Name').focus();
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('MaProvincialCouncils','Create'),CHtml::normalizeUrl(array('MaProvincialCouncils/addNew','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {                          
		if(	status=="success")
		{    
			$("#MaDistrict_Provincial_Councils_ID").append(data);
            $("#MaProvincialCouncilsDialog").dialog("close");               			                       
		}                         
		else
		{                        
			                    
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaProvincialCouncilsDialog')); 
	 
	 ?>
		<?php /*echo CHtml::ajaxSubmitButton(Yii::t('MaProvincialCouncils','Create'),CHtml::normalizeUrl(array('MaProvincialCouncils/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#MaDistrict_Provincial_Councils_ID").append(data);
                        $("#MaProvincialCouncilsDialog").dialog("close");
                    }'),array('id'=>'closeMaProvincialCouncilsDialog'));*/ ?>

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->