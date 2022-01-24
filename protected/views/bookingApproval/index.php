<?php
$this->breadcrumbs=array(
	'Booking Approvals',
);

$this->menu=array(
	array('label'=>'Create BookingApproval', 'url'=>array('create')),
	array('label'=>'Manage BookingApproval', 'url'=>array('admin')),
);
?>

<h1>Booking Approvals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
