


<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<div class="formTable">
            
        <div class="tblrow">
            	<div class="tdOne"><?php echo $form->label($model,'Garage_Type_ID'); ?></div>
		<div class="tdTwo"><?php  $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'Garage_Type_ID',
                                'attribute'=>'Garage_Type_ID',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0',
                                    
                                ),
                                'source'=>$this->createUrl("MaGarageType/GarageType"),
                                'htmlOptions'=>array('class'=>'midText',
                                    'data-value'=>'',
                                   
                                ),
                            ));?></div>
	</div>
	
	<div class="tblrow">
            	<div class="tdOne"><?php echo $form->label($model,'Garage_Name'); ?></div>
		<div class="tdTwo"><?php  $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'Garage_Name',
                                'attribute'=>'Garage_Name',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0',
                                    
                                ),
                                'source'=>$this->createUrl("MaGarages/GarageName"),
                                'htmlOptions'=>array('class'=>'largeText',
                                'data-value'=>'',
                                   
                                ),
                            ));?></div>
	</div>



	<div class="row" style="padding-left:37%;font-weight:bold">
		<?php echo CHtml::submitButton('Search');?>
	</div>




	<div class="row" style="display:none">
		<?php echo $form->label($model,'Land_Phone_No'); ?>
		<?php echo $form->textField($model,'Land_Phone_No',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'Mobile_No'); ?>
		<?php echo $form->textField($model,'Mobile_No',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'Fax'); ?>
		<?php echo $form->textField($model,'Fax',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'Email'); ?>
		<?php echo $form->textField($model,'Email',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'Contact_No'); ?>
		<?php echo $form->textField($model,'Contact_No',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'Registration_No'); ?>
		<?php echo $form->textField($model,'Registration_No',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row" style="display:none">
		<?php echo $form->label($model,'Owner_Name'); ?>
		<?php echo $form->textField($model,'Owner_Name',array('size'=>60,'maxlength'=>200)); ?>
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