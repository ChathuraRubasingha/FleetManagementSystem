<?php
$this->breadcrumbs=array(
	'Main Menu'=>array('site/booking'),
	
);

/*$this->menu=array(
	array('label'=>'List Booking Request', 'url'=>array('index')),
	array('label'=>'Create Booking Request', 'url'=>array('create')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('trbooking-request-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="group">
<h1>Pending Booking Requests</h1>

<!--<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>-->

<?php /*?><?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?><?php */?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'trbooking-request-grid',
	'dataProvider'=>$model->getPendingBookingRequests(),
	//'filter'=>$model,
	'columns'=>array(
		'Booking_Request_ID',
		'User_ID',
		
		array('name'=>'Category_Name', 'header'=>'Vehicle Category', 'value'=>'$data->vehicleCategory->Category_Name'),
		'No_of_Passengers',
		array('name'=>'Allocation_Type', 'header'=>'Allocation Type', 'value'=>'$data->allocationType->Allocation_Type'),
	
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}',
			'updateButtonUrl'=>'Yii::app()->createUrl("/tRVehicleBooking/create", array("id" =>     
			$data["Booking_Request_ID"],"from"=>$data["From"],"to"=>$data["To"],"cv"=>$data["Vehicle_Category_ID"]))',
		),
	)
)); ?>
</div>
