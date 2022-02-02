<?php
$this->breadcrumbs=array(
	'Ma Tyre Types',
);

$this->menu=array(
	array('label'=>'Create Tyre Type', 'url'=>array('create')),
	array('label'=>'Manage Tyre Type', 'url'=>array('admin')),
);
?>

<h1>Tyre Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
