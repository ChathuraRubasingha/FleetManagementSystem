<?php
$this->breadcrumbs=array(
	'Vehicle Drivers',
);

$this->menu=array(
	array('label'=>'Create VehicleDriver', 'url'=>array('create')),
	array('label'=>'Manage VehicleDriver', 'url'=>array('admin')),
);
?>

<h1>Vehicle Drivers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
