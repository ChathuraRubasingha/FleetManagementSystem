



<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<div class="formTable">
            
        <div class="tblrow">
            	<div class="tdOne"><?php echo $form->label($model,'Vehicle_Status'); ?></div>
		<div class="tdTwo"><?php  $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'Vehicle_Status',
                                'attribute'=>'Vehicle_Status',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0',
                                    
                                ),
                                'source'=>$this->createUrl("VehicleStatus/vehicleStatus"),
                                'htmlOptions'=>array('class'=>'midText',

                                    'data-value'=>'',
                                ),
                            ));?></div>
	</div>
	
	



	<div class="row" style="padding-left:37%;font-weight:bold">
		<?php echo CHtml::submitButton('Search');?>
	</div>


<?php $this->endWidget(); ?>

</div><!-- search-form -->