<?php
$this->breadcrumbs=array(
	'Trrepair Estimate Details',
);

$this->menu=array(
	array('label'=>'Create TRRepairEstimateDetails', 'url'=>array('create')),
	array('label'=>'Manage TRRepairEstimateDetails', 'url'=>array('admin')),
);
?>

<h1>Trrepair Estimate Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
