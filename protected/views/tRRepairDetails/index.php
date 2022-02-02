<?php
$this->breadcrumbs=array(
	'Repair Details',
);

$this->menu=array(
	array('label'=>'Create Repair Details', 'url'=>array('create')),
	array('label'=>'Manage Repair Details', 'url'=>array('admin')),
);
?>

<h1>Repair Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
