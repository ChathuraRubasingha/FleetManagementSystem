


<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<?php

$superUserStatus = Yii::app()->getModule('user')->user()->superuser;
$assign = Yii::app()->request->getQuery('assign');
?>

<div class="formTable">
            
        <div class="tblrow">
            	<div class="tdOne"><?php echo $form->label($model,'Vehicle_No'); ?></div>
		<div class="tdTwo"><?php
                            $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
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
                            ?></div>
	</div>
	
	<div class="tblrow">
            	<div class="tdOne"><?php echo $form->label($model,'Vehicle_Category_ID'); ?></div>
		<div class="tdTwo"><?php
                            $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
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
                            ?></div>
	</div>
    
        <div class="tblrow">
            	<div class="tdOne"><?php echo $form->label($model,'Make_ID'); ?></div>
		<div class="tdTwo"><?php
                            $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
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
                            ?></div>
	</div>



	<div class="row" style="padding-left:37%;font-weight:bold">
		<?php echo CHtml::submitButton('Search');?>
	</div>



	
	
		
	

	
		
		<?php #echo $form->textField($model,'Vehicle_Category_ID'); ?>
        
	

	<?php /*?><div class="row">
		<?php echo $form->label($model,'Purchase_Value'); ?>
		<?php echo $form->textField($model,'Purchase_Value',array('size'=>50,'maxlength'=>50)); ?>
	</div><?php */?>

	<?php /*?><div class="row">
		<?php echo $form->label($model,'Purchase_Date'); ?>
		<?php echo $form->textField($model,'Purchase_Date'); ?>
	</div><?php */?>

	<!--<div class="row">
		<?php echo $form->label($model,'Engine_No'); ?>
		<?php echo $form->textField($model,'Engine_No',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Chassis_No'); ?>
		<?php echo $form->textField($model,'Chassis_No',array('size'=>50,'maxlength'=>50)); ?>
	</div>
	-->
    
    
   <!-- <div class="row">
    	<?php echo $form->label($model,'Location_ID'); ?>
         <?php echo $form->dropdownlist($model,'Location_ID',CHtml::listData(
            MaLocation::model()->findAllLocations(),'Location_ID','Location_Name'),array('prompt' => '--- Please Select ---','class'=>'midSelect'));   ?>
               
    </div>-->
 
	

<?php $this->endWidget(); ?>

</div><!-- search-form -->