<?php
$this->breadcrumbs=array(
	'Vehicle Statuses',
);

$this->menu=array(
	array('label'=>'Create New Vehicle Status', 'url'=>array('create')),
	array('label'=>'Manage Vehicle Status', 'url'=>array('admin')),
);
?>

<h1>Vehicle Statuses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
