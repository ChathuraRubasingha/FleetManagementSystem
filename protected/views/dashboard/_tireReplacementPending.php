<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'trtyre-details-grid',
	'dataProvider'=>$tireReplacementPending,
	//'filter'=>$model,
	'columns'=>array(
		//'Tyre_Details_ID',
		'Vehicle_No',
		array('name'=>'Location', 'type'=>'raw', 'value'=>array($this, 'gridLocation')),
		//'Driver_ID',
		array('name'=>'Full_Name', 'header'=>'Driver', 'value'=>'$data->driver->Full_Name'),
		//'Tyre_Type_ID',
		array('name'=>'Tyre_Type', 'header'=>'Tyre Type', 'value'=>'$data->tyreType->Tyre_Type'),
		//'Tyre_Size_ID',
		array('name'=>'Tyre_Size', 'header'=>'Tyre Size', 'value'=>'$data->tyreSize->Tyre_Size'),
		'Tyre_quantity',
		//'Approved_By',
		/*
		'Approved_Date',
		'Replace_Status',
		'Replace_Date',
		'add_by',
		'add_date',
		'edit_by',
		'edit_date',
		*/
		array(
			'class'=>'CButtonColumn',
					'template'=>'{view}',
					'viewButtonUrl'=>'Yii::app()->createUrl("/tRTyreDetails/approveTyre", array("tyreDetailsId" =>     
					$data["Tyre_Details_ID"], "Vid" =>     
					$data["Vehicle_No"]))',
		),
	),
)); ?>