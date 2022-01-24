<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'trbattery-details-grid',
	'dataProvider'=>$batteryReplacementPending,
	//'filter'=>$model,
	'columns'=>array(
		//'Battery_Details_ID',
		'Vehicle_No',
		array('name'=>'Location', 'type'=>'raw', 'value'=>array($this, 'gridLocation')),
		array('name'=>'Full_Name', 'header'=>'Driver', 'value'=>'$data->driver->Full_Name'),
		//'Driver_ID',
		array('name'=>'Battery_Type', 'header'=>'Battery Type', 'value'=>'$data->batteryType->Battery_Type'),
		array(
			'class'=>'CButtonColumn',
					'template'=>'{view}',
					'viewButtonUrl'=>'Yii::app()->createUrl("/tRBatteryDetails/approveBattery", array("batterydetailsid" =>     
					$data["Battery_Details_ID"], "vid" =>     
					$data["Vehicle_No"]))',
		),
	),
)); ?>