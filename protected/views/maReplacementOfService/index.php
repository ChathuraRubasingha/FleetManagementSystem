<?php
$this->breadcrumbs=array(
	'Ma Replacement Of Services',
);

$this->menu=array(
	array('label'=>'Create MaReplacementOfService', 'url'=>array('create')),
	array('label'=>'Manage MaReplacementOfService', 'url'=>array('admin')),
);
?>

<h1>Ma Replacement Of Services</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
