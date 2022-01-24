<?php
$this->breadcrumbs=array(
	'Trvehicle Bookings',
);

$this->menu=array(
	array('label'=>'Create TRVehicleBooking', 'url'=>array('create')),
	array('label'=>'Manage TRVehicleBooking', 'url'=>array('admin')),
);
?>

<h1>Trvehicle Bookings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
