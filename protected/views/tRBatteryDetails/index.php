<?php
$this->breadcrumbs=array(
	'Trbattery Details',
);

$this->menu=array(
	array('label'=>'Create TRBatteryDetails', 'url'=>array('create')),
	array('label'=>'Manage TRBatteryDetails', 'url'=>array('admin')),
);
?>

<h1>Trbattery Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
