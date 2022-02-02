<?php
/* @var $this MaDistrictController */
/* @var $model MaDistrict */
/* @var $form CActiveForm */
?>


<div class="form" id="MaDistrictDialogForm">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-district-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true, 
)); ?>
<?php /*$form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-district-form',
	'enableAjaxValidation'=>false,
));*/ ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<table width="550" >
	<div class="row">
 		<tr><td width="160px">
		<?php echo $form->labelEx($model,'Provincial_Councils_ID'); ?>
        </td>
         <td>
    <?php echo $form->dropDownList($model,'Provincial_Councils_ID',CHtml::listData(MaProvincialCouncils::model()->findAllProvincial(),'Provincial_Councils_ID','Provincial_Councils_Name'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
                 <!--<div id="MaProvincialCouncils"><?php /*echo CHtml::ajaxButton(Yii::t('MaProvincialCouncils',' '),$this->createUrl('MaProvincialCouncils/addNew'),array(
        'onclick'=>'if (MaProvincialCouncilsAjaxComplete) { $("#MaProvincialCouncilsDialog").dialog("open"); return false; } else { MaProvincialCouncilsAjaxComplete = true; }',
        'update'=>'#MaProvincialCouncilsDialog'
        ),array('id'=>'showMaProvincialCouncilsDialog', 'class'=>'addBtn', 'title'=>'Add New Item'));*/?>
    <div id="MaProvincialCouncilsDialog"></div>
</div>       -->
</td>
</tr>
        <tr><td/><td><?php echo $form->error($model,'Provincial_Councils_ID'); ?></td></tr>
	</div>
    
	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'District_Name'); ?>
        </td><td>
		<?php echo $form->textField($model,'District_Name',array('size'=>30,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'District_Name'); ?>
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
			$('#closeMaDistrictDialog').click(function()
			{
				$('#MaDistrict_District_Name').focus();
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('MaDistrict','Create'),CHtml::normalizeUrl(array('MaDistrict/addNew','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			 $("#MaDsDivision_District_ID").append(data);
			$("#MaLocation_District_ID").append(data);
			$("#MaDistrictDialog").dialog("close");
                       			                       
		}                         
		else
		{                        
			                       
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaDistrictDialog')); 
	 
	 ?>
     
		<?php /*echo CHtml::ajaxSubmitButton(Yii::t('MaDistrict','Create'),CHtml::normalizeUrl(array('MaDistrict/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#MaDsDivision_District_ID").append(data);
						$("#MaLocation_District_ID").append(data);
                        $("#MaDistrictDialog").dialog("close");
                    }'),array('id'=>'closeMaDistrictDialog'));*/ ?>

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->