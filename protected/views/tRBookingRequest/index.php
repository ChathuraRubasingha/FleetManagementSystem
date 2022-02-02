<?php
$this->breadcrumbs=array(
	'Booking Requests',
);

$this->menu=array(
	array('label'=>'Create Booking Request', 'url'=>array('create')),
	array('label'=>'Manage Booking Request', 'url'=>array('admin')),
);
?>

<h1>Booking Requests</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
