<?php
$this->breadcrumbs=array(
	'Odometer Update Remarks',
);

$this->menu=array(
	array('label'=>'Create OdometerUpdateRemark', 'url'=>array('create')),
	array('label'=>'Manage OdometerUpdateRemark', 'url'=>array('admin')),
);
?>

<h1>Odometer Update Remarks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
