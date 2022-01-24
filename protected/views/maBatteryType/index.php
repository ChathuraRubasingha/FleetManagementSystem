<?php
$this->breadcrumbs=array(
	'Ma Battery Types',
);

$this->menu=array(
	array('label'=>'Create Battery Type', 'url'=>array('create')),
	array('label'=>'Manage Battery Type', 'url'=>array('admin')),
);
?>

<h1>Battery Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
