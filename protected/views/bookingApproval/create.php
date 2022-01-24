<?php
$this->breadcrumbs=array(
	'Booking Approvals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BookingApproval', 'url'=>array('index')),
	array('label'=>'Manage BookingApproval', 'url'=>array('admin')),
);
?>

<h1>Create BookingApproval</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>