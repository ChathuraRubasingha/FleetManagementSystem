

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ma-repairs-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php
  	$vehicleId = Yii::app()->session['maintenVehicleId'];
?>

<?php 
	date_default_timezone_set('Asia/Colombo'); 
?>

    <div class="classname" style="width:200px; height:28px; margin-left:200px; font-size:25px"><p align="center"><b><?php echo $vehicleId; ?></b></p></div> 
    
	<p class="note">Fields with <span class="required">*</span> are required.</p>
    
	<?php date_default_timezone_set('Asia/Colombo'); ?>
	<?php echo $form->errorSummary($model); ?>
    
  
    <table width="550" border="1">
	<div class="row">
    <tr><td>
		<?php echo $form->hiddenfield($model,'Vehicle_No'); ?>
        </td><td>
		<?php echo $form->hiddenfield($model,'Vehicle_No',array('size'=>20,'value'=>$vehicleId,'readonly'=>true)); ?>
       <?php /*?> <?php echo $form->dropdownlist($model,'Vehicle_No',CHtml::listData(MaVehicleRegistry::model()->findAll(),'Vehicle_No','Vehicle_No'),array('empty'=>'please select'));  ?><?php */?>
		<?php echo $form->error($model,'Vehicle_No'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Total_Cost'); ?>
        </td><td>
		<?php echo $form->textField($model,'Total_Cost',array('size'=>20,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'Total_Cost'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Repairs_Date'); ?>
		<?php /*?><?php echo $form->textField($model,'Repairs_Date'); ?><?php */?>
        </td><td>
        <?php  
			$this->widget('zii.widgets.jui.CJuiDatePicker', array( 
						  'model'=>$model,
                          'attribute'=>'Repairs_Date',
                          'options'=>array(
                          'showAnim'=>'fold',
                          'dateFormat'=>'yy-mm-dd',
                          'changeMonth' => 'true',
                          'changeYear' => 'true',
                          'duration'=>'fast',
                          'showButtonPanel' => 'true', ),
                          'htmlOptions'=>array(
                          'id'=>'Repairs_Date',
                          'style'=>'height:15px;',
                             ),
                     ));?>
		<?php echo $form->error($model,'Repairs_Date'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Garage_ID'); ?>
        </td><td>
		<?php /*echo $form->textField($model,'Garage_ID'); */?>
        <?php echo $form->dropdownlist($model,'Garage_ID',CHtml::listData(MaGarages::model()->findAll(),'Garage_ID','Garage_Name'),array('empty'=>'please select'));  ?>
		<?php echo $form->error($model,'Garage_ID'); ?>
        </td></tr>
	</div>

	<div class="row">
    <tr><td>
		<?php echo $form->labelEx($model,'Repairs_Type_ID'); ?>
        </td><td>
		<?php /*echo $form->textField($model,'Repairs_Type_ID'); */?>
        <?php echo $form->dropdownlist($model,'Repairs_Type_ID',CHtml::listData(MaRepairType::model()->findAll(),'Repairs_Type_ID','Repairs_Type'),array('empty'=>'please select'));  ?>
		<?php echo $form->error($model,'Repairs_Type_ID'); ?>
        </td></tr>
	</div>

	
	<div class="row">
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));
		}
		else {
		echo $form->hiddenField($model,'add_by',array('size'=>50,'maxlength'=>50));	
		}
		 ?>
	</div>

	<div class="row">
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'add_date',array('value'=>date("Y-m-d : H:i:s", time())));
		} 
		else 
		{
		echo $form->hiddenField($model,'add_date',array());	
		}
		?>
	</div>
    
   <div class="row">
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>'Not Edited'));
		} else {
		echo $form->hiddenField($model,'edit_by',array('size'=>50,'maxlength'=>50,'value'=>Yii::app()->getModule('user')->user()->username));   	
		}
		?>
	</div>

	<div class="row">
		<?php 
		if ($model->isNewRecord){
		echo $form->hiddenField($model,'edit_date',array('value'=>'Not Edited'));
		} else {
		echo $form->hiddenField($model,'edit_date',array('value'=>date("Y-m-d : H:i:s", time())));	
		}
		?>
	</div>
    </table>

	<div class="row buttons" style="padding-left:75%;font-weight:bold">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save');?>
</div>

<?php $this->endWidget(); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ma-repairs-grid',
	'dataProvider'=>$model->getRepairHistory(),
	//'filter'=>$model,
	'columns'=>array(
		//'Repairs_ID',
		//'Vehicle_No',
		'Total_Cost',
		'Repairs_Date',
		//'Garage_ID',
		array('name'=>'Garage_Name', 'header'=>'Garage Name', 'value'=>'$data->garage->Garage_Name'),
		//'Repairs_Type_ID',
		array('name'=>'Repairs_Type', 'header'=>'Repairs Type', 'value'=>'$data->repairsType->Repairs_Type'),
		/*
		'add_by',
		'add_date',
		'edit_by',
		'edit_date',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',
			'updateButtonUrl'=>'Yii::app()->createUrl("/maRepairs/update", array("id" =>$data["Repairs_ID"]))',
		),
	),
)); ?>

</div><!-- form -->