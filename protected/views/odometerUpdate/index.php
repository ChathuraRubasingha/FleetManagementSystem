<?php
$this->breadcrumbs=array(
	'Odometer Updates',
);

$this->menu=array(
	array('label'=>'Create OdometerUpdate', 'url'=>array('create')),
	array('label'=>'Manage OdometerUpdate', 'url'=>array('admin')),
);
?>

<h1>Odometer Updates</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
