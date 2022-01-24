<?php
$this->breadcrumbs=array(
	'Dashboard Permissions'=>array('index'),
	$model->ID=>array('view','id'=>$model->ID),
	'Update',
);

$this->menu=array(
	array('label'=>'List DashboardPermission', 'url'=>array('index')),
	array('label'=>'Create DashboardPermission', 'url'=>array('create')),
	array('label'=>'View DashboardPermission', 'url'=>array('view', 'id'=>$model->ID)),
	array('label'=>'Manage DashboardPermission', 'url'=>array('admin')),
);
?>

<h1>Update DashboardPermission <?php echo $model->ID; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>