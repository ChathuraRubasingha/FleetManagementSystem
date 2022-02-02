<?php
$this->breadcrumbs=array(
	'Ma Repairs',
);

$this->menu=array(
	array('label'=>'Create Repairs', 'url'=>array('create')),
	array('label'=>'Manage Repairs', 'url'=>array('admin')),
);
?>

<h1>Repairs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
