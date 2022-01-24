



    <?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
    )); ?>

<div class="formTable">
            
        <div class="tblrow">
            	<div class="tdOne"><?php echo $form->label($model,'Repairs_Type'); ?></div>
		<div class="tdTwo"><?php  $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                        'model'=>$model,
                        'name'=>'Repairs_Type',
                        'attribute'=>'Repairs_Type',
                        'options'=>array(
                            'minLength'=>'0',
                        ),
                        'source'=>$this->createUrl("MaRepairType/RepairType"),
                        'htmlOptions'=>array(
                            'data-value'=>'',

                        ),
                        ));?></div>
	</div>
	
	<div class="row" style="padding-left:37%;font-weight:bold">
		<?php echo CHtml::submitButton('Search');?>
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

	
	

<?php $this->endWidget(); ?>

</div><!-- search-form -->