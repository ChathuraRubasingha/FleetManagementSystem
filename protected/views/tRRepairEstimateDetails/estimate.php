<?php
$this->breadcrumbs=array(
	'Repair'=>array('tRRepairRequest/repair'),
	'Repair Estimate for Approval',
);
?>

<?php
$vehicleId = Yii::app()->session['maintenVehicleId'];
?>

<!--<div class="group" style="width:200px; height:110px; float:left; margin-left:30px; margin-top:0px">
    <div id="menu"  style="width:200px; float:left; padding-left:2px; padding-top:2px">

             <ul>
             	<li><?php #echo CHtml::link('Back to main',array('/tRLicense/Create')); ?></li>
            
                <li><?php # echo CHtml::link('New Repair Request',array('/tRRepairRequest/create')); ?></li>
                
                <li><?php #echo CHtml::link('Estimate Repair Requests',array('/tRRepairRequest/admin')); ?></li>
                
               <li><?php #echo CHtml::link('Approve Repair Estimate',array('/tRRepairEstimateDetails/estimate')); ?></li>
                
                <li><?php #echo CHtml::link('Add Repair Details',array('/tRRepairEstimateDetails/approvedEstimates')); ?></li>
                            
            </ul>

	</div>
    
</div>-->
 <div class="groups" style="margin-left:330px; margin-top:24px;">
<h1 style="margin-bottom:50px;">Select Repair Estimate for Approval</h1>

<div class="classname" style="width:200px; height:28px; margin-left:270px; margin-bottom:50px; font-size:25px">
	<p align="center"><b><?php echo $vehicleId; ?></b></p>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'trrepair-estimate-details-grid',
	'dataProvider'=>$model->getPendingEstimates(),
	//'filter'=>$model,
	'columns'=>array(
		//'Estimate_ID',
		//'Request_ID',
		'Vehicle_No',
		//'Garage_ID',
		array('name'=>'Garage_Name', 'header'=>'Garage', 'value'=>'$data->garage->Garage_Name'),
		'Total_Estimate',
		//'Estimate_Date',
		/*
		'Approved_By',
		'Approved_Date',
		'Estimate_Status',
		'add_by',
		'add_date',
		'edit_by',
		'edit_date',
		*/
		array(
			'class'=>'CButtonColumn',
					'template'=>'{view}',
					'viewButtonUrl'=>'Yii::app()->createUrl("/tRRepairEstimateDetails/approveEstimate", array("estimateId" =>     
					$data["Estimate_ID"],"requestId" => $data["Request_ID"]))',
		),
	),
)); ?>
</div>