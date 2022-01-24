<?php
$this->breadcrumbs=array(
	'Ma Garages',
);

$this->menu=array(
	array('label'=>'Create Garages', 'url'=>array('create')),
	array('label'=>'Manage Garages', 'url'=>array('admin')),
);
?>

<h1>Garages</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
