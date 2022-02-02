<?php
$this->breadcrumbs=array(
	'Fuel Types',
);

$this->menu=array(
	array('label'=>'Create Fuel Type', 'url'=>array('create')),
	array('label'=>'Manage Fuel Type', 'url'=>array('admin')),
);
?>

<h1>Fuel Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
