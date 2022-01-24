<?php
$this->breadcrumbs=array(
	'Allocation Types',
);

$this->menu=array(
	array('label'=>'Create New Allocation Type', 'url'=>array('create')),
	array('label'=>'Manage Allocation Type', 'url'=>array('admin')),
);
?>

<h1>Allocation Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
