<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'trfuel-request-details-grid',
	'dataProvider'=>$fuelRequestApproved,
	//'filter'=>$model,
	'columns'=>array(
            'Request_Date',
            'Vehicle_No',
            array('name'=>'Location', 'type'=>'raw', 'value'=>array($this, 'gridLocation')),
            array('name'=>'Driver', 'header'=>'Driver Name', 'value'=>'$data->driver->Full_Name'),
            'Required_Fuel_Capacity',
            'Fuel_Balance',
            'Meter_Reading',
		
	array(
                'class'=>'CButtonColumn',
                'template'=>'{view}',
                'viewButtonUrl'=>'Yii::app()->createUrl("/tRFuelRequestDetails/rejectRequest", array("requestId" =>     
                $data["Fuel_Request_ID"],"vid" =>     
		$data["Vehicle_No"]))',
		),
		
	),
)); ?>