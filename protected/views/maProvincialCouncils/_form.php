

<?php
/* @var $this MaProvincialCouncilsController */
/* @var $model MaProvincialCouncils */
/* @var $form CActiveForm */
?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-provincial-councils-form',
	'enableAjaxValidation'=>false,
)); 
$curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime");



?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        <div class="formTable">
            
    <div class="tblrow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Provincial_Councils_Name'); ?>
        </div><div class="tdTwo">
		<?php echo $form->textField($model,'Provincial_Councils_Name',array('class'=>'midText','maxlength'=>200)); ?>
		<?php echo $form->error($model,'Provincial_Councils_Name'); ?>
        </div></div>
	

	<?php date_default_timezone_set('Asia/Colombo'); ?>
	
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));
		}
		else {
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50));	
		}
		 ?>
	
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_date',array('value'=>$curDateTime));
		} else {
		echo $form->hiddenField($model,'add_date',array());	
		}
		?>
	
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>'Not Edited'));
		} else {
		echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));   	
		}
		?>
	
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'edit_date',array('value'=>'Not Edited'));
		} else {
		echo $form->hiddenField($model,'edit_date',array('value'=>$curDateTime));	
		}
		?>
	

	<div class="row" style="padding-left:37%;font-weight:bold">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save');?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->