<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'trfuel-request-details-grid',
	'dataProvider'=>$fuelRequestPending,
	//'filter'=>$model,
	'columns'=>array(
		'Request_Date',
		'Vehicle_No',
		array('name'=>'Location', 'type'=>'raw', 'value'=>array($this, 'gridLocation')),
		//'Driver_ID',
		array('name'=>'Driver', 'header'=>'Driver Name', 'value'=>'$data->driver->Full_Name'),
		'Required_Fuel_Capacity',
		//'Driver_ID',
		//array('name'=>'Driver_ID', 'header'=>'driver Name', 'value'=>'$data->driver->Full_Name'),
	
		'Fuel_Balance',
		
		
		'Meter_Reading',
		/*
		'Approve_Status',
		'add_by',
		'add_date',
		'edit_by',
		'edit_date',
		*/
	array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
			'viewButtonUrl'=>'Yii::app()->createUrl("/tRFuelRequestDetails/approveFuelRequest", array("requestId" =>     
			$data["Fuel_Request_ID"], "Vid" =>     
					$data["Vehicle_No"]))',
		),
		
	),
)); ?>