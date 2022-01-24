<div class="wide form" >

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table width="550" style="margin-left:20px;">
<tr>
	<td class="row">
		<?php echo $form->label($model,'Vehicle_No'); ?>
		<?php //echo $form->textField($model,'Vehicle_No',array('size'=>20,'maxlength'=>20)); ?>
                <?php
                            $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'Vehicle_No',
                                'attribute'=>'Vehicle_No',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0',
                                    
                                ),
                                'source'=>$this->createUrl("MaVehicleRegistry/vehicleNumber"),
                                'htmlOptions'=>array(
                                    'data-value'=>'',
                                   
                                ),
                            ));
                            ?>
	</td>
</tr>
<tr>
	<td class="row">
		<?php echo $form->label($model,'Driver_ID'); ?>
		<?php //echo $form->textField($model,'Driver_ID'); ?>
                                <?php
                            $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'Driver_ID',
                                'attribute'=>'Driver_ID',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0',
                                    
                                ),
                                'source'=>$this->createUrl("MaDriver/driver"),
                                'htmlOptions'=>array(
                                    'data-value'=>'',
                                   
                                ),
                            ));
                            ?>
	</td>
</tr>
<tr>
    	<td class="row">
		<?php echo $form->label($model,'remark_id'); ?>
		<?php //echo $form->textField($model,'remark_id'); ?>
               <?php echo $form->dropDownList($model, 'remark_id', CHtml::listData(OdometerUpdateRemark::model()->findAll(), 'remark_id', 'description'), array('prompt' => '--- Please Select ---', 'class' => 'midSelect')); ?>
	</td>
</tr>
<!--<tr>
	<td class="row">
		<?php echo $form->label($model,'in_time'); ?>
		<?php echo $form->textField($model,'in_time'); ?>
	</td>
</tr>
<tr>
	<td class="row">
		<?php echo $form->label($model,'out_time'); ?>
		<?php echo $form->textField($model,'out_time'); ?>
	</td>
</tr>-->
<!--<tr>
	<td class="row">
		<?php echo $form->label($model,'out_odo_reading'); ?>
		<?php echo $form->textField($model,'out_odo_reading'); ?>
	</td>
</tr>       -->
<!--


	<div class="row">
		<?php echo $form->label($model,'in_odo_reading'); ?>
		<?php echo $form->textField($model,'in_odo_reading'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'added_by'); ?>
		<?php echo $form->textField($model,'added_by',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>150)); ?>
	</div>-->

<tr>
	<td class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</td>
</tr>
</table> 
<?php $this->endWidget(); ?>

</div><!-- search-form -->