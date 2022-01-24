<?php
$this->breadcrumbs=array(
	'Ma Insurance Types',
);

$this->menu=array(
	array('label'=>'Create Insurance Type', 'url'=>array('create')),
	array('label'=>'Manage Insurance Type', 'url'=>array('admin')),
);
?>

<h1>Insurance Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
