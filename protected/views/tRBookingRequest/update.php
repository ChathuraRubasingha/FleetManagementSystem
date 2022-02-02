<?php
$this->breadcrumbs=array(
	'Manage'=>array('admin'),
	'Update',

);

$this->menu=array(
	//array('label'=>'List Booking Request', 'url'=>array('index')),
	array('label'=>'Create Booking Request', 'url'=>array('create')),
	//array('label'=>'View Booking Request', 'url'=>array('view', 'id'=>$model->Booking_Request_ID)),
	array('label'=>'Manage Booking Request', 'url'=>array('admin')),
);
?>
<div class="group">
<h1>Update Booking Request</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>