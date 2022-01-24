<?php
$this->breadcrumbs=array(
	'Vehicle Categories',
);

$this->menu=array(
	array('label'=>'Create New Vehicle Category', 'url'=>array('create')),
	array('label'=>'Manage Vehicle Category', 'url'=>array('admin')),
);
?>

<h1>Vehicle Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
