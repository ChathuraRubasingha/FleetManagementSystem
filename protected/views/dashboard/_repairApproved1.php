

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'trrepair-approved-request-grid',
	'dataProvider'=>$repairApproved,
	//'filter'=>$model,
	'columns'=>array(
		'Request_ID',
		'Vehicle_No',
		array('name'=>'Full_Name', 'header'=>'Driver', 'value'=>'$data->driver->Full_Name'),
		'Description_Of_Failure',
		//'Garage_ID',
		#array('name'=>'Garage_Name', 'header'=>'Garage', 'value'=>'$data->garage->Garage_Name'),
		#'Total_Estimate',
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
		/*array(
			#'class'=>'CButtonColumn',
					#'template'=>'{view}',
					#'viewButtonUrl'=>'Yii::app()->createUrl("/TRRepairRequest/repair", array("estimateId" =>     
					#$data["Estimate_ID"],"requestId" => $data["Request_ID"]))',
		),*/
	),
)); ?>