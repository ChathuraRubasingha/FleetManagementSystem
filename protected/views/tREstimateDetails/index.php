<?php
$this->breadcrumbs=array(
	'Trestimate Details',
);

$this->menu=array(
	array('label'=>'Create TREstimateDetails', 'url'=>array('create')),
	array('label'=>'Manage TREstimateDetails', 'url'=>array('admin')),
);
?>

<h1>Trestimate Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
