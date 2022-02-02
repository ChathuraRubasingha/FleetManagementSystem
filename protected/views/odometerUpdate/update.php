<?php
$this->breadcrumbs=array(
	'Odometer Updates'=>array('index'),
	$model->update_id=>array('view','id'=>$model->update_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OdometerUpdate', 'url'=>array('index')),
	array('label'=>'Create OdometerUpdate', 'url'=>array('create')),
	array('label'=>'View OdometerUpdate', 'url'=>array('view', 'id'=>$model->update_id)),
	array('label'=>'Manage OdometerUpdate', 'url'=>array('admin')),
);
?>

<h1>Update OdometerUpdate <?php echo $model->update_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>