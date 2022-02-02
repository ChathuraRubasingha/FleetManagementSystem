<?php
/* @var $this MaGnDivisionController */
/* @var $model MaGnDivision */
/* @var $form CActiveForm */
?>


<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-gn-division-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true, 
)); ?>
<?php /*$form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-gn-division-form',
	'enableAjaxValidation'=>false,
));*/ ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<table width="550">
	<div class="row">
 		<tr><td width="160px">
		<?php echo $form->labelEx($model,'DS_Division_ID'); ?>
		<?php /*?><?php echo $form->textField($model,'DS_Division_ID'); ?><?php */?>
        </td>
         <!--<td> <div id="MaDsDivision">
    <?php echo $form->dropDownList($model,'DS_Division_ID',CHtml::listData(MaDsDivision::model()->findAll(),'DS_Division_ID','DS_Division'),array('prompt'=>'--- Please Select ---', 'class'=>'midSelect')); ?>
    <?php echo CHtml::ajaxButton(Yii::t('MaDsDivision',' '),$this->createUrl('MaDsDivision/addNew'),array(
        'onclick'=>'if (MaDsDivisionAjaxComplete) { $("#MaDsDivisionDialog").dialog("open"); return false; } else { MaDsDivisionAjaxComplete = true; }',
        'update'=>'#MaDsDivisionDialog'
        ),array('id'=>'showMaDsDivisionDialog', 'class'=>'addBtn', 'title'=>'Add New Item'));?>
    <div id="MaDsDivisionDialog"></div>
</div>
 <?php echo $form->error($model,'DS_Division_ID'); ?>
                    
</td>-->
        
        <td>
        <?php echo $form->dropdownlist($model,'DS_Division_ID',CHtml::listData(MaDsDivision::model()->findAllDsDivisions(),      	    	     	    	'DS_Division_ID','DS_Division'),array('empty'=>'--Please Select--', 'class'=>'midSelect'));  ?>
		<?php  echo $form->error($model,'DS_Division_ID'); ?>
        </td></tr>
	</div>
    
	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'GN_Division'); ?>
        </td><td>
		<?php echo $form->textField($model,'GN_Division',array('size'=>30,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'GN_Division'); ?>
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
			$('#closeMaGnDivisionDialog').click(function()
			{
				$('#MaGnDivision_GN_Division').focus();
				//alert('ok');
			});
		});
		
		");
		?>
  
        
        
        <?php echo CHtml::ajaxSubmitButton(Yii::t('MaGnDivision','Create'),CHtml::normalizeUrl(array('MaGnDivision/addNew','render'=>false)),                 array(
	  'type'=>'post',                    
	  'success'=>'function(data, status) 
	  {              
	  	                         
		if(	status=="success")
		{    
			$("#MaLocation_GN_Division_ID").append(data);
			$("#MaGnDivisionDialog").dialog("close");              			                       
		}                         
		else
		{                        
			$("#Location_Name").focus();                       
		}                          
	 }',                                         
	 'beforeSend'=>'function()
	 {                                                   
	 	                     
	 }'),array('id'=>'closeMaGnDivisionDialog')); 
	 
	 ?>
		<?php /*echo CHtml::ajaxSubmitButton(Yii::t('MaGnDivision','Create'),CHtml::normalizeUrl(array('MaGnDivision/addNew','render'=>false)),array('success'=>'js: function(data) {
                        $("#MaLocation_GN_Division_ID").append(data);
					    $("#MaGnDivisionDialog").dialog("close");
                    }'),array('id'=>'closeMaGnDivisionDialog'));*/ ?>

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->