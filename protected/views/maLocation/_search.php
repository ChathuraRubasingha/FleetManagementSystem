

<?php
/* @var $this MaLocationController */
/* @var $model MaLocation */
/* @var $form CActiveForm */
?>



<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php /*?><div class="row">
		<?php echo $form->label($model,'Location_ID'); ?>
		<?php echo $form->textField($model,'Location_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Provincial_Councils_ID'); ?>
		<?php echo $form->textField($model,'Provincial_Councils_ID'); ?>
	</div><?php */?>

	<!--<div class="row">
		<?php #echo $form->label($model,'District_ID'); ?>
		<?php # echo $form->textField($model,'District_ID'); ?>
	</div>-->

	<?php /*?><div class="row">
		<?php echo $form->label($model,'DS_Division_ID'); ?>
		<?php echo $form->textField($model,'DS_Division_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'GN_Division_ID'); ?>
		<?php echo $form->textField($model,'GN_Division_ID'); ?>
	</div><?php */?>
        
        <div class="formTable">
            
        <div class="tblrow">
            	<div class="tdOne"><?php echo $form->label($model,'Location_Name'); ?></div>
		<div class="tdTwo"><?php  $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'Location_Name',
                                'attribute'=>'Location_Name',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0',
                                    
                                ),
                                'source'=>$this->createUrl("MaLocation/location"),
                                'htmlOptions'=>array('class'=>'largeText',
                                'data-value'=>'',
                                   
                                ),
                            ));?></div>
	</div>
	
	



	<div class="row" style="padding-left:37%;font-weight:bold">
		<?php echo CHtml::submitButton('Search');?>
	</div>


        



	<?php /*?><div class="row">
		<?php echo $form->label($model,'Address'); ?>
		<?php echo $form->textField($model,'Address',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Telephone'); ?>
		<?php echo $form->textField($model,'Telephone',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Fax'); ?>
		<?php echo $form->textField($model,'Fax',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Email'); ?>
		<?php echo $form->textField($model,'Email',array('size'=>60,'maxlength'=>100)); ?>
	</div><?php */?>

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