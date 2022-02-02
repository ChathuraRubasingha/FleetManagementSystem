



<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<div class="formTable">
            
        <div class="tblrow">
            	<div class="tdOne"><?php echo $form->label($model,'Srvice_Station_Name'); ?></div>
		<div class="tdTwo"><?php  $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'Srvice_Station_Name',
                                'attribute'=>'Srvice_Station_Name',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0',
                                    
                                ),
                                'source'=>$this->createUrl("MaServiceStation/ServiceStation"),
                                'htmlOptions'=>array('class'=>'largeText',
                                'data-value'=>'',
                                   
                                ),
                            ));?></div>
	</div>
	
	



	<div class="row" style="padding-left:37%;font-weight:bold">
		<?php echo CHtml::submitButton('Search');?>
	</div>





<?php /*?>
	<div class="row">
		<?php echo $form->label($model,'Address'); ?>
		<?php echo $form->textField($model,'Address',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Land_phone_No'); ?>
		<?php echo $form->textField($model,'Land_phone_No',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Mobile_No'); ?>
		<?php echo $form->textField($model,'Mobile_No',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Fax'); ?>
		<?php echo $form->textField($model,'Fax',array('size'=>20,'maxlength'=>20)); ?>
	</div><?php */?>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'Contact_Person'); ?>
		<?php echo $form->textField($model,'Contact_Person',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'Registration_No'); ?>
		<?php echo $form->textField($model,'Registration_No',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'Owner_Name'); ?>
		<?php echo $form->textField($model,'Owner_Name',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'Email'); ?>
		<?php echo $form->textField($model,'Email',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'add_by'); ?>
		<?php echo $form->textField($model,'add_by',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'add_date'); ?>
		<?php echo $form->textField($model,'add_date'); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'edit_by'); ?>
		<?php echo $form->textField($model,'edit_by',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'edit_date'); ?>
		<?php echo $form->textField($model,'edit_date'); ?>
	</div>

	

<?php $this->endWidget(); ?>

</div><!-- search-form -->