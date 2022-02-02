<?php
$this->breadcrumbs=array(
	'Ma Repair Types',
);

$this->menu=array(
	array('label'=>'Create Repair Type', 'url'=>array('create')),
	array('label'=>'Manage Repair Type', 'url'=>array('admin')),
);
?>

<h1>Repair Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
