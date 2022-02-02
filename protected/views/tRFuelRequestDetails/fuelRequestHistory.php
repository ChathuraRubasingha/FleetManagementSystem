<?php
$this->breadcrumbs=array(
	'Trfuel Request Details'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List TRFuelRequestDetails', 'url'=>array('index')),
	array('label'=>'Manage Fuel Requests', 'url'=>array('maVehicleRegistry/fuelRequest')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('trfuel-request-details-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="group">

<h1>Fuel Request Details</h1>


<?php echo CHtml::link('','',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'trfuel-request-details-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
		'Request_Date',
		'Vehicle_No',
		//'Driver_ID',
		array('name'=>'Driver_ID', 'header'=>'Driver Name', 'value'=>'$data->driver->Full_Name'),
		'Required_Fuel_Capacity',
		//'Driver_ID',
		
		//array('name'=>'Driver', 'header'=>'Driver', 'value'=>'$data->driver->Full_Name'),
		'Fuel_Balance',
		'Approve_Status',
		/*
		'Meter_Reading',
		'Approve_Status',
		'add_by',
		'add_date',
		'edit_by',
		'edit_date',
		*/
	array(
			'class'=>'CButtonColumn',
					'template'=>'{view}',
					'viewButtonUrl'=>'Yii::app()->createUrl("/tRFuelRequestDetails/view", array("id" =>     
					$data["Fuel_Request_ID"], "menuId"=>"fuel"))',
		),
	),
)); 
?>
</div>