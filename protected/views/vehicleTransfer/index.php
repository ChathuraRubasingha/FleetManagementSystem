<?php
$this->breadcrumbs=array(
	'Vehicle Transfers',
);

$this->menu=array(
	array('label'=>'Create VehicleTransfer', 'url'=>array('create')),
	array('label'=>'Manage VehicleTransfer', 'url'=>array('admin')),
);
?>

<h1>Vehicle Transfers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
