<?php
$this->breadcrumbs=array(
	'Trvehicle Repair Details',
);

$this->menu=array(
	array('label'=>'Create TRVehicleRepairDetails', 'url'=>array('create')),
	array('label'=>'Manage TRVehicleRepairDetails', 'url'=>array('admin')),
);
?>

<div class="group">
<h1>TRVehicle Repair Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

</div>