

    <?php $curDateTime = MaVehicleRegistry::model()->getServerDate("dateTime"); ?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-supplier-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
  <div class="formTable">
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Supplier_Name'); ?>
        </div><div class="tdTwo">
		<?php echo $form->textField($model,'Supplier_Name',array('class'=>'midText','maxlength'=>200)); ?>
		<?php echo $form->error($model,'Supplier_Name'); ?>
        </div></div>
	
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Contact_Person'); ?>
        </div><div class="tdTwo">
		<?php echo $form->textField($model,'Contact_Person',array('class'=>'midText','maxlength'=>20)); ?>
		<?php echo $form->error($model,'Contact_Person'); ?>
        </div></div>
	
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Land_phone_No'); ?>
        </div><div class="tdTwo">
		<?php echo $form->textField($model,'Land_phone_No',array('class'=>'midText','maxlength'=>10)); ?>
		<?php echo $form->error($model,'Land_phone_No'); ?>
        </div></div>
	
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Mobile'); ?>
        </div><div class="tdTwo">
		<?php echo $form->textField($model,'Mobile',array('class'=>'midText','maxlength'=>10)); ?>
		<?php echo $form->error($model,'Mobile'); ?>
        </div></div>
	
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Fax'); ?>
        </div><div class="tdTwo">
		<?php echo $form->textField($model,'Fax',array('class'=>'midText','maxlength'=>10)); ?>
		<?php echo $form->error($model,'Fax'); ?>
        </div></div>
	
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Email'); ?>
        </div><div class="tdTwo">
		<?php echo $form->textField($model,'Email',array('class'=>'midText','maxlength'=>100)); ?>
		<?php echo $form->error($model,'Email'); ?>
        </div></div>
	
    <div class="tblRow"><div class="tdOne">
		<?php echo $form->labelEx($model,'Address'); ?>
        </div><div class="tdTwo">
		<?php #echo $form->textField($model,'Address',array('size'=>60,'maxlength'=>250)); ?>
         <?php echo $form->textArea($model,'Address',array('rows'=>6, 'cols'=>56)); ?>
		<?php echo $form->error($model,'Address'); ?>
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
	

	<div class="row" style="padding-left:36%;font-weight:bold">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save');?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->