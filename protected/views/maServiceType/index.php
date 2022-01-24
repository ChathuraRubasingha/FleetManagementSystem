<?php
$this->breadcrumbs=array(
	'Ma Service Types',
);

$this->menu=array(
	array('label'=>'Create Service Type', 'url'=>array('create')),
	array('label'=>'Manage Service Type', 'url'=>array('admin')),
);
?>

<h1>Service Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
