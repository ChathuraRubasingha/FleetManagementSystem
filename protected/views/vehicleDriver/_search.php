


<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<div class="formTable">
            
        <div class="tblrow">
            	<div class="tdOne"><?php echo $form->label($model,'Vehicle_No'); ?></div>
		<div class="tdTwo"><?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'Vehicle_No',
                                'attribute'=>'Vehicle_No',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0',
                                    
                                ),
                                'source'=>$this->createUrl("MaVehicleRegistry/vehicleNumber"),
                                'htmlOptions'=>array('class'=>'midText',
                                    'data-value'=>'',
                                   
                                ),
                            ));?></div>
	</div>
	
	<div class="tblrow">
            	<div class="tdOne"><?php echo $form->label($model,'Driver_ID'); ?></div>
		<div class="tdTwo"><?php  $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'Driver_ID',
                                'attribute'=>'Driver_ID',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0', 
                                    
                                ),
                                'source'=>$this->createUrl("MaDriver/driver"),
                                'htmlOptions'=>array('class'=>'midText',
                                'data-value'=>'',
                                   
                                ),
                            )); ?></div>
	</div>
    
        <div class="tblrow">
            	<div class="tdOne"><?php echo $form->label($model,'Location_ID'); ?></div>
		<div class="tdTwo"><?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'Location_ID',
                                'attribute'=>'Location_ID',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0', 
                                    
                                ),
                                'source'=>$this->createUrl("MaLocation/location"),
                                'htmlOptions'=>array('class'=>'largeText',
                                'data-value'=>'',
                                   
                                ),
                            )); ?></div>
	</div>



	<div class="row" style="padding-left:37%;font-weight:bold">
		<?php echo CHtml::submitButton('Search');?>
	</div>


<?php $this->endWidget(); ?>

</div><!-- search-form -->