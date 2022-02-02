<?php
$this->breadcrumbs=array(
	'Vehicle Maintenance'=>array('maVehicleRegistry/maintenanceRegistry'),
	'Vehicle Repair History',
);
?>
<?php
$vehicleId = Yii::app()->session['maintenVehicleId'];
?>
<div class="group" style="width:200px; float:left; margin-left:65px; margin-top:-3px">
    <div id="menu"  style="width:200px; float:left; padding-left:10px; padding-top:20px">

            <ul>
            
                <li><?php echo CHtml::link('New Repair Request',array('/tRRepairRequest/create')); ?></li>
                
                <li><?php echo CHtml::link('Estimate Repair Requests',array('/tRRepairRequest/admin')); ?></li>
                
                <li><?php echo CHtml::link('Approve Repair Estimate',array('/tRRepairEstimateDetails/estimate')); ?></li>
                
                <li><?php echo CHtml::link('Add Repair Details',array('/tRRepairEstimateDetails/approvedEstimates')); ?></li>
                            
            </ul>

	</div>
</div>
<div class="groups" style="padding-left:40px; margin-left:410px; margin-top:18px">
<h1>Repair History of the Vehicle</h1>
<div class="classname" style="width:200px; height:28px; margin-left:270px; font-size:25px"><p align="center"><b><?php echo $vehicleId; ?></b></p></div>
 <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'trvehicle-repair-details-grid',
	'dataProvider'=>$modelRepair->search(),
	//'filter'=>$modelRepair,
	'columns'=>array(
		/*'Repair_ID',*/
		//'Estimate_ID',
		'Vehicle_No',
		//'Garage_ID',
		array('name'=>'Garage_Name', 'header'=>'Garage', 'value'=>'$data->garage->Garage_Name'),
		'Repair_Cost',
		'Description_Of_Repair',
		'Repaired_Date',
		/*
		'Repaired_Date',
		'add_by',
		'add_date',
		'edit_by',
		'edit_date',
		*/
		/*array(
			'class'=>'CButtonColumn',
		),*/
	),
)); ?>
</div>