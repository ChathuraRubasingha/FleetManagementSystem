<?php
$this->breadcrumbs=array(
	'Ma Garage Types',
);

$this->menu=array(
	array('label'=>'Create Garage Type', 'url'=>array('create')),
	array('label'=>'Manage Garage Type', 'url'=>array('admin')),
);
?>

<h1>Garage Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
