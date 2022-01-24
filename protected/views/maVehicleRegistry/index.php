<?php
$this->breadcrumbs=array(
	'Vehicle Registries',
);

$this->menu=array(
	array('label'=>'Add New Vehicle', 'url'=>array('create')),
	array('label'=>'Manage Vehicle Registry', 'url'=>array('admin')),
);
?>

<h1>Vehicle Registries</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
