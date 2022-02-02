


<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<?php



?>

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
                            ));
			
			#echo $form->dropDownList($model,'Vehicle_No',CHtml::listData(MaVehicleRegistry::model()->findAllVehicles(),'Vehicle_No','Vehicle_No'),array( 'empty'=>'--- Please Select ---','class'=>'midSelect')); ?></div>
	</div>
	
	<div class="tblrow">
            	<div class="tdOne"><?php echo $form->label($model,'Vehicle_Category_ID'); ?></div>
		<div class="tdTwo"><?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'Vehicle_Category_ID',
                                'attribute'=>'Vehicle_Category_ID',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0',
                                    
                                ),
                                'source'=>$this->createUrl("VehicleCategory/vehicleCategory"),
                                'htmlOptions'=>array('class'=>'midText',
                                    'data-value'=>'',
                                   
                                ),
                            ));
			
			 #echo $form->dropDownList($model,'Vehicle_Category_ID',CHtml::listData(VehicleCategory::model()->findAll(),'Category_Name','Category_Name'),array('prompt'=>'--- Please Select ---','class'=>'midSelect')); ?></div>
	</div>
    
        <div class="tblrow">
            	<div class="tdOne"><?php echo $form->label($model,'Make_ID'); ?></div>
		<div class="tdTwo"><?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'Make_ID',
                                'attribute'=>'Make_ID',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0',
                                    
                                ),
                                'source'=>$this->createUrl("MaMake/make"),
                                'htmlOptions'=>array('class'=>'midText',

                                    'data-value'=>'',
                                ),
                            ));
							
							# echo $form->dropDownList($model,'Make_ID',CHtml::listData(MaMake::model()->findAllMakes(),'Make','Make'),array( 'empty'=>'--- Please Select ---','class'=>'midSelect')); ?></div>
	</div>



	<div class="row" style="padding-left:37%;font-weight:bold">
		<?php echo CHtml::submitButton('Search');?>
	</div>





<?php $this->endWidget(); ?>

</div><!-- search-form -->