<?php
$this->breadcrumbs=array(
	'Ma Service Stations',
);

$this->menu=array(
	array('label'=>'Create Service Station', 'url'=>array('create')),
	array('label'=>'Manage Service Station', 'url'=>array('admin')),
);
?>

<h1>Service Stations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
