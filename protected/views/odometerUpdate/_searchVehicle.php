
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<?php



?>
<table width="550" style="padding-left:20px;">
	<div class="row">
        <tr style="width:200px;">
            <td><?php echo $form->label($model,'Vehicle_No'); ?></td>
            <td><?php  $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
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
			
			#echo $form->dropDownList($model,'Vehicle_No',CHtml::listData(MaVehicleRegistry::model()->findAllVehicles(),'Vehicle_No','Vehicle_No'),array( 'empty'=>'--- Please Select ---','class'=>'midSelect')); ?></td>
        </tr>
    </div>
    
     <div class="row">
      <!--  <tr>
            <td><?php #echo $form->label($model,'Vehicle_Category_ID'); ?></td>
            <td><?php /*$this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'Vehicle_Category_ID',
                                'attribute'=>'Vehicle_Category_ID',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0',
                                    
                                ),
                                'source'=>$this->createUrl("VehicleCategory/vehicleCategory"),
                                'htmlOptions'=>array(
                                
                                   
                                ),
                            ));*/
			
			 #echo $form->dropDownList($model,'Vehicle_Category_ID',CHtml::listData(VehicleCategory::model()->findAll(),'Category_Name','Category_Name'),array('prompt'=>'--- Please Select ---','class'=>'midSelect')); ?></td>
        </tr>-->
    </div>
    
     
     <div class="row">
        <tr>
            <td><?php #echo $form->label($model,'Location_ID'); ?></td>
            <td><?php /*$this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                                'model'=>$model,
                                'name'=>'Location_ID',
                                'attribute'=>'Location_ID',
                                // additional javascript options for the autocomplete plugin
                                'options'=>array(
                                    'minLength'=>'0', 
                                    
                                ),
                                'source'=>$this->createUrl("MaLocation/location"),
                                'htmlOptions'=>array('class'=>'largeText'
                                
                                   
                                ),
                            ));*/
							
							#echo $form->dropdownlist($model,'Location_ID',CHtml::listData(MaLocation::model()->findAllLocations(),'Location_ID','Location_Name'),array('prompt' => '--- Please Select ---','class'=>'largeSelect'));   ?></td>
        </tr>
    </div>
</table> 
	<?php /*?><div class="row">
		<?php echo $form->label($model,'Purchase_Value'); ?>
		<?php echo $form->textField($model,'Purchase_Value',array('size'=>50,'maxlength'=>50)); ?>
	</div><?php */?>

	<?php /*?><div class="row">
		<?php echo $form->label($model,'Purchase_Date'); ?>
		<?php echo $form->textField($model,'Purchase_Date'); ?>
	</div><?php */?>

	
   
                
<?php /*?>	<div class="row">
		<?php echo $form->label($model,'Fuel_Type_ID'); ?>
		<?php echo $form->textField($model,'Fuel_Type_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Tyre_Size_ID'); ?>
		<?php echo $form->textField($model,'Tyre_Size_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Tyre_Type_ID'); ?>
		<?php echo $form->textField($model,'Tyre_Type_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'No_of_Tyres'); ?>
		<?php echo $form->textField($model,'No_of_Tyres',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Model'); ?>
		<?php echo $form->textField($model,'Model',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Make'); ?>
		<?php echo $form->textField($model,'Make',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Battery_Type_ID'); ?>
		<?php echo $form->textField($model,'Battery_Type_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Vehicle_Status_ID'); ?>
		<?php echo $form->textField($model,'Vehicle_Status_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Service_Mileage'); ?>
		<?php echo $form->textField($model,'Service_Mileage',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Servicing_Period'); ?>
		<?php echo $form->textField($model,'Servicing_Period',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Fuel_Consumption'); ?>
		<?php echo $form->textField($model,'Fuel_Consumption',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Fitness_test'); ?>
		<?php echo $form->textField($model,'Fitness_test',array('size'=>60,'maxlength'=>100)); ?>
	</div><?php ?>

	<?php ?><div class="row">
		<?php echo $form->label($model,'add_by'); ?>
		<?php echo $form->textField($model,'add_by',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'add_date'); ?>
		<?php echo $form->textField($model,'add_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'edit_by'); ?>
		<?php echo $form->textField($model,'edit_by',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'edit_date'); ?>
		<?php echo $form->textField($model,'edit_date'); ?>
	</div>
<?php */?>
	<div class="row buttons" style="margin-left:45%">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->