<?php
$this->breadcrumbs=array(
	'Booking Approvals'=>array('index'),
	$model->Booking_Approval_ID=>array('view','id'=>$model->Booking_Approval_ID),
	'Update',
);

$this->menu=array(
	array('label'=>'List BookingApproval', 'url'=>array('index')),
	array('label'=>'Create BookingApproval', 'url'=>array('create')),
	array('label'=>'View BookingApproval', 'url'=>array('view', 'id'=>$model->Booking_Approval_ID)),
	array('label'=>'Manage BookingApproval', 'url'=>array('admin')),
);
?>

<h1>Update BookingApproval <?php echo $model->Booking_Approval_ID; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>