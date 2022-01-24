<?php
$this->breadcrumbs=array(
	'Vehicle Locations',
);

$this->menu=array(
	array('label'=>'Create New VehicleLocation', 'url'=>array('create')),
	array('label'=>'Manage VehicleLocation', 'url'=>array('admin')),
);
?>

<h1>Vehicle Locations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
