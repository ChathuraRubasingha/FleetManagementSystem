
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'trrepair-estimate-details-grid',
	'dataProvider'=>$repairApproved,
	//'filter'=>$model,
	'columns'=>array(
		//'Estimate_ID',
		//'Request_ID',
		'Vehicle_No',
		array('name'=>'Location', 'type'=>'raw', 'value'=>array($this, 'gridLocation')),
		'Approved_Date',
		//'Garage_ID',
		array('name'=>'Garage_Name', 'header'=>'Garage', 'value'=>'$data->garage->Garage_Name'),
		//'Total_Estimate',
		array('name'=>'Total_Estimate', 'header'=>'Total Estimate', 'value'=>'number_format($data->Total_Estimate,2)', 'htmlOptions'=>array('style'=>'text-align:right; padding-right:50px;')),
		//'Estimate_Date',
		
		'Approved_By',
		/*
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
					'viewButtonUrl'=>'Yii::app()->createUrl("/tRRepairEstimateDetails/rejectRepairEstimate", array("estimateId" =>     
					$data["Estimate_ID"],"vid" => $data["Vehicle_No"]))',
		),
	),
)); ?>