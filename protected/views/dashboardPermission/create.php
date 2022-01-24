<?php
$this->breadcrumbs=array(
	'Dashboard Permissions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DashboardPermission', 'url'=>array('index')),
	array('label'=>'Manage DashboardPermission', 'url'=>array('admin')),
);
?>

<h1>Create DashboardPermission</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>